<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\OfflineInvoice;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Concern;
use App\Models\ProductType;
use App\Models\StockInvoice;
use App\Models\Stocks;
use App\Models\Strep;
use App\Models\Variant;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OfflineInvoiceController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoiceData = OfflineInvoice::get();
        // return $invoiceData;
        return view("backend.offline_stock_billing.offlineinvoice", compact('invoiceData'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $currentAdmin = Auth::guard('admin')->user();
        $adminCenterId = $currentAdmin->center_id ?? null; // Get the center id of the current admin

        $products = Variant::with([
            'product:title,id',
            'strep:id,title',
            'batches:center_id,variant_id'
        ])->whereHas('batches', function ($batchQuery) use ($adminCenterId) {
            $batchQuery->where('stock', '>', 0)->where('center_id', $adminCenterId)
                ->whereNotNull('center_id');
        })->orderBy('id', 'desc')
            ->get(['product_id', 'id', 'size']);
        // return $products;

        // Fetch other necessary data as needed
        $brands = Brand::get();
        $categories = Category::where('is_parent', 1)->get();
        $strep = Strep::get();
        $concerns = Concern::where('is_parent', 1)->get();
        $ptypes = ProductType::where('is_parent', 1)->get();

        return view('backend.offline_stock_billing.buy', compact('products', 'brands', 'categories', 'strep', 'concerns', 'ptypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         // Get customer details
         $customerName = $request->input('customer_name');
         $customerEmail = $request->input('customer_email');
         $customerPhone = $request->input('customer_phone');
         $customerAddress = $request->input('customer_address');
         $invoiceType = $request->input('invoice_type');
 
         // Get product details
         $products = $request->input('products');
         $prices = $request->input('prices');
         $batchNos = $request->input('batch_nos');
         $quantities = $request->input('quantities');
 
         $totalAmount = 0;
         $subTotal = 0;
         $subTotals = 0;
         $totalCgst = 0;
         $totalSgst = 0;
         $totalQuantity = 0;
 
         $productSummary = [];
         foreach ($products as $key => $productId) {
             $batchNo = $batchNos[$key] ?? null;
             $quantity = $quantities[$key] ?? 1; // Default to 1 if quantity not provided
 
             // Validate product and batch number
             if (!$batchNo) {
                 return response()->json(['success' => false, 'message' => 'Invalid product or batch selected.']);
             }
 
             $variant = Variant::where('id', $productId)->first();
             $discount = $variant->discount ?? 0; // Discount in percentage
             $product = $variant->product;
             // Calculate the price after applying the discount
             $price = $prices[$key];
             $discountAmount = ($price * $discount) / 100;
             $priceAfterDiscount = $price - $discountAmount;
 
             // if ($invoiceType == 'GST') {
             //     $cgstRate = $product->cgst ?? 0;
             //     $sgstRate = $product->sgst ?? 0;
             // } elseif ($invoiceType == 'Non_GST') {
             //     $cgstRate = 0;
             //     $sgstRate = 0;
             // } elseif ($invoiceType == 'Bill_of_Supply') {
             //     $cgstRate = 0;
             //     $sgstRate = 0;
             // }
             $cgstRate = $product->cgst ?? 0;
             $sgstRate = $product->sgst ?? 0;
 
             // Calculate tax amounts on the discounted price
             $productSubTotal = $priceAfterDiscount * $quantity;
             $productCgst = $productSubTotal * ($cgstRate / 100);
             $productSgst = $productSubTotal * ($sgstRate / 100);
             $productSubTotals = $productSubTotal;
             $productTotalPrice = $productSubTotal + $productCgst + $productSgst;
 
             // Summarize the products for the invoice
             $uniqueKey = $productId . '_' . $batchNo;
             if (isset($productSummary[$uniqueKey])) {
                 $productSummary[$uniqueKey]['quantity'] += $quantity;
                 $productSummary[$uniqueKey]['sub_total'] += $productSubTotal;
                 $productSummary[$uniqueKey]['sub_totals'] += $productSubTotals;
                 $productSummary[$uniqueKey]['cgst_amount'] += $productCgst;
                 $productSummary[$uniqueKey]['sgst_amount'] += $productSgst;
                 $productSummary[$uniqueKey]['total_price'] += $productTotalPrice;
             } else {
                 $productSummary[$uniqueKey] = [
                     'name' => $product->title,
                     'product_id' => $product->id,
                     'original_price' => $price,
                     'discount_percentage' => $discount,
                     'price_after_discount' => $priceAfterDiscount,
                     'quantity' => $quantity,
                     'sub_total' => $productSubTotal,
                     'sub_totals' => $productSubTotals,
                     'cgst_rate' => $cgstRate,
                     'sgst_rate' => $sgstRate,
                     'cgst_amount' => $productCgst,
                     'sgst_amount' => $productSgst,
                     'total_price' => $productTotalPrice,
                     'batch_no' => $batchNo,
                 ];
             }
 
             // Update totals
             $subTotal += $productSubTotal;
             $totalCgst += $productCgst;
             $totalSgst += $productSgst;
             $totalAmount += $productTotalPrice;
             $subTotals += $productSubTotals;
             $totalQuantity += $quantity;
         }
 
         DB::beginTransaction();
 
         try {
             foreach ($productSummary as $uniqueKey => $data) {
                 $productId = explode('_', $uniqueKey)[0];
                 $variant = Variant::where('id', $productId)->first();
                 $stock = Stocks::where('variant_id', $productId)
                     ->where('batch_no', $data['batch_no'])
                     ->first();
 
                 if ($variant && $variant->stock >= $data['quantity'] && $stock && $stock->stock >= $data['quantity']) {
                     $variant->stock -= $data['quantity']; // Deduct from variant stock
                     $variant->save();
 
                     $stock->stock -= $data['quantity']; // Deduct from batch stock
                     $stock->save();
                 } else {
                     DB::rollBack();
                     return response()->json(['success' => false, 'message' => 'Insufficient stock for product ' . $data['name']]);
                 }
             }
 
             // $amountInWords = Helper::inwords($totalAmount);
             DB::commit(); // Commit transaction
 
             // Prepare invoice data
             $invoiceData = [
                 'invoice_no' => 'INV-' . time(),
                 'invoice_date' => now()->format('Y-m-d H:i:s'),
                 'payment_method' => 'Online',
                 'sub_total' => $subTotal,
                 'total_quantity' => $totalQuantity,
                 'total_cgst' => $totalCgst,
                 'total_sgst' => $totalSgst,
                 'total_amount' => $totalAmount,
                 'sub_totals' => $subTotals,
                 'amount_in_words' => $totalAmount,
                 'invoice_type' => $invoiceType,
                 'products' => $productSummary,
                 'customer_name' => $customerName,
                 'customer_email' => $customerEmail,
                 'customer_phone' => $customerPhone,
                 'customer_address' => $customerAddress,
             ];
             // Insert invoice data using the model  
             $invoice = OfflineInvoice::create($invoiceData);
             return response()->json([
                 'success' => true,
                 'invoiceUrl' => route('stocks.generateInvoiceShow', $invoice->invoice_no),
             ]);
 
         } catch (Exception $e) {
             DB::rollBack();
             return response()->json(['success' => false, 'message' => 'Error generating invoice: ' . $e->getMessage()]);
         }
    }


    public function getProductBatches($productId)
    {
        $batches = Stocks::where('variant_id', $productId)
            ->where('stock', '>', 0)
            ->get(['id', 'batch_no', 'price', 'stock', 'expiry']);
        
        return response()->json(['batches' => $batches]);
    }

    public function getProductStock($stockId)
    {
        $stock = Stocks::where('id', $stockId)
            ->get('stock')->first(); 
        return response()->json(['stock' => $stock]);
    }

    public function generateInvoice(Request $request)
    {
        // return $request->all();
        // $request->validate([
        //     'customer_name' => 'required',
        //     'customer_phone' => 'required',
        //     'products' => 'required',
        //     'batch_nos' => 'required',
        // ]);


        // Get customer details
        $customerName = $request->input('customer_name');
        $customerEmail = $request->input('customer_email');
        $customerPhone = $request->input('customer_phone');
        $customerAddress = $request->input('customer_address');
        $invoiceType = $request->input('invoice_type');

        // Get product details
        $products = $request->input('products');
        $prices = $request->input('prices');
        $batchNos = $request->input('batch_nos');
        $quantities = $request->input('quantities');

        $totalAmount = 0;
        $subTotal = 0;
        $subTotals = 0;
        $totalCgst = 0;
        $totalSgst = 0;
        $totalQuantity = 0;

        $productSummary = [];
        foreach ($products as $key => $productId) {
            $batchNo = $batchNos[$key] ?? null;
            $quantity = $quantities[$key] ?? 1; // Default to 1 if quantity not provided

            // Validate product and batch number
            if (!$batchNo) {
                return response()->json(['success' => false, 'message' => 'Invalid product or batch selected.']);
            }

            $variant = Variant::where('id', $productId)->first();
            $discount = $variant->discount ?? 0; // Discount in percentage
            $product = $variant->product;
            // Calculate the price after applying the discount
            $price = $prices[$key];
            $discountAmount = ($price * $discount) / 100;
            $priceAfterDiscount = $price - $discountAmount;

            // if ($invoiceType == 'GST') {
            //     $cgstRate = $product->cgst ?? 0;
            //     $sgstRate = $product->sgst ?? 0;
            // } elseif ($invoiceType == 'Non_GST') {
            //     $cgstRate = 0;
            //     $sgstRate = 0;
            // } elseif ($invoiceType == 'Bill_of_Supply') {
            //     $cgstRate = 0;
            //     $sgstRate = 0;
            // }


            $cgstRate = $product->cgst ?? 0;
            $sgstRate = $product->sgst ?? 0;

            // Calculate tax amounts on the discounted price
            $productSubTotal = $priceAfterDiscount * $quantity;
            $productCgst = $productSubTotal * ($cgstRate / 100);
            $productSgst = $productSubTotal * ($sgstRate / 100);
            $productSubTotals = $productSubTotal;
            $productTotalPrice = $productSubTotal + $productCgst + $productSgst;

            // Summarize the products for the invoice
            $uniqueKey = $productId . '_' . $batchNo;
            if (isset($productSummary[$uniqueKey])) {
                $productSummary[$uniqueKey]['quantity'] += $quantity;
                $productSummary[$uniqueKey]['sub_total'] += $productSubTotal;
                $productSummary[$uniqueKey]['sub_totals'] += $productSubTotals;
                $productSummary[$uniqueKey]['cgst_amount'] += $productCgst;
                $productSummary[$uniqueKey]['sgst_amount'] += $productSgst;
                $productSummary[$uniqueKey]['total_price'] += $productTotalPrice;
            } else {
                $productSummary[$uniqueKey] = [
                    'name' => $product->title,
                    'product_id' => $product->id,
                    'original_price' => $price,
                    'discount_percentage' => $discount,
                    'price_after_discount' => $priceAfterDiscount,
                    'quantity' => $quantity,
                    'sub_total' => $productSubTotal,
                    'sub_totals' => $productSubTotals,
                    'cgst_rate' => $cgstRate,
                    'sgst_rate' => $sgstRate,
                    'cgst_amount' => $productCgst,
                    'sgst_amount' => $productSgst,
                    'total_price' => $productTotalPrice,
                    'batch_no' => $batchNo,
                ];
            }

            // Update totals
            $subTotal += $productSubTotal;
            $totalCgst += $productCgst;
            $totalSgst += $productSgst;
            $totalAmount += $productTotalPrice;
            $subTotals += $productSubTotals;
            $totalQuantity += $quantity;
        }

        DB::beginTransaction();

        try {
            foreach ($productSummary as $uniqueKey => $data) {
                $productId = explode('_', $uniqueKey)[0];
                $variant = Variant::where('id', $productId)->first();
                $stock = Stocks::where('variant_id', $productId)
                    ->where('batch_no', $data['batch_no'])
                    ->first();

                if ($variant && $variant->stock >= $data['quantity'] && $stock && $stock->stock >= $data['quantity']) {
                    $variant->stock -= $data['quantity']; // Deduct from variant stock
                    $variant->save();

                    $stock->stock -= $data['quantity']; // Deduct from batch stock
                    $stock->save();
                } else {
                    DB::rollBack();
                    return response()->json(['success' => false, 'message' => 'Insufficient stock for product ' . $data['name']]);
                }
            }

            // $amountInWords = Helper::inwords($totalAmount);
            DB::commit(); // Commit transaction

            // Prepare invoice data
            $invoiceData = [
                'invoice_no' => 'INV-' . time(),
                'invoice_date' => now()->format('Y-m-d H:i:s'),
                'payment_method' => 'Online',
                'sub_total' => $subTotal,
                'total_quantity' => $totalQuantity,
                'total_cgst' => $totalCgst,
                'total_sgst' => $totalSgst,
                'total_amount' => $totalAmount,
                'sub_totals' => $subTotals,
                'amount_in_words' => $totalAmount,
                'invoice_type' => $invoiceType,
                'products' => $productSummary,
                'customer_name' => $customerName,
                'customer_email' => $customerEmail,
                'customer_phone' => $customerPhone,
                'customer_address' => $customerAddress,
            ];
            // Insert invoice data using the model  
            $invoice = StockInvoice::create($invoiceData);
            return response()->json([
                'success' => true,
                'invoiceUrl' => route('stocks.generateInvoiceShow', $invoice->invoice_no),
            ]);

        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Error generating invoice: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
    */

    public function show(OfflineInvoice $offlineInvoice)
    {

        return view('backend.stock.invoice', compact('offlineInvoice'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OfflineInvoice $offlineInvoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OfflineInvoice $offlineInvoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OfflineInvoice $offlineInvoice)
    {
        $offlineInvoice->delete(); 
        return redirect()->back()->with('success', 'Invoice trashed successfully.');
    }
    
}
