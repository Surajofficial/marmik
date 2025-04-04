<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Center;
use App\Models\StockInvoice;
use App\Models\StockProductReturn;
use Helper;
use Illuminate\Http\Request;
use App\Models\Settings;
use App\Models\User;
use App\Models\Brand;
use App\Models\Category;

use App\Models\Strep;
use App\Models\Concern;
use App\Models\ProductType;
use App\Models\Product;
use App\Models\Stocks;
use App\Models\Variant;
use PDF;

// Import the PDF facade
use App\Rules\MatchOldPassword;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;


class AdminController extends Controller
{
    public function index()
    {
        $data = Admin::select(DB::raw("COUNT(*) as count"), DB::raw("DAYNAME(created_at) as day_name"), DB::raw("DAY(created_at) as day"))
            ->where('created_at', '>', Carbon::today()->subDays(6))
            ->groupBy('day_name', 'day')
            ->orderBy('day')
            ->get();
        $array[] = ['Name', 'Number'];
        foreach ($data as $key => $value) {
            $array[++$key] = [$value->day_name, $value->count];
        }
        //  return $data;
        return view('backend.index')->with('users', json_encode($array));
    }

    public function profile()
    {
        $profile = Auth()->guard('admin')->user();
        // return $profile;
        return view('backend.users.profile')->with('profile', $profile);
    }

    public function buy()
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

        return view('backend.stock.buy', compact('products', 'brands', 'categories', 'strep', 'concerns', 'ptypes'));
    }

    public function searchInvoiceId(Request $request)
    {
        $term = $request->input('term');
        $invoices = StockInvoice::where('invoice_no', 'LIKE', '%' . $term . '%')
            ->where('total_quantity', '>=', 1)
            ->limit(10)
            ->get(['invoice_no']);
        return response()->json($invoices);
    }


    public function getInvoiceDetails(Request $request)
    {
        $invoiceId = $request->input('invoice_id');
        $invoice = StockInvoice::where('invoice_no', $invoiceId)->first();

        if (!$invoice) {
            return response()->json(['success' => false, 'message' => 'Invoice not found.']);
        }

        $customer = [
            'invoice_type' => $invoice->invoice_type,
            'customer_email' => $invoice->customer_email,
            'customer_name' => $invoice->customer_name,
            'customer_phone' => $invoice->customer_phone,
            'customer_address' => $invoice->customer_address,
        ];
        $products = $invoice->products;
        return response()->json([
            'success' => true,
            'customer' => $customer,
            'products' => $products,
        ]);

    }

    public function processStockProductReturn(Request $request)
    {
        DB::beginTransaction();
        try {
            $stockInvoice = StockInvoice::where('invoice_no', $request->invoice_id)->first();

            if (!$stockInvoice) {
                return response()->json([
                    'error' => 'Invoice not found'
                ], 404);
            }

            $originalProducts = $stockInvoice->products;
            $returnedProducts = [];
            $subTotal = 0;
            $subTotals = 0;
            $totalCgst = 0;
            $totalSgst = 0;
            $totalAmountWithGST = 0;
            $totalQuantityReturned = 0;

            $productIds = $request->product_id;
            $batchNos = $request->batch_no;
            $quantities = $request->quantity;
            $prices = $request->price;
            $return_date = $request->return_date;

            foreach ($productIds as $index => $productId) {
                $batchNo = $batchNos[$index];
                $quantityReturned = $quantities[$index];
                $price = $prices[$index];

                $productKey = $productId . '_' . $batchNo;

                if (array_key_exists($productKey, $originalProducts)) {
                    $originalProduct = $originalProducts[$productKey];

                    if ($quantityReturned > $originalProduct['quantity']) {
                        return response()->json([
                            'error' => 'Returned quantity cannot exceed the purchased quantity for ' . $originalProduct['name']
                        ], 400);
                    }

                    $productSubTotal = $price * $quantityReturned;
                    $productSubTotals = $productSubTotal;

                    $subTotal += $productSubTotal;
                    $subTotals += $productSubTotals;
                    $totalQuantityReturned += $quantityReturned;

                    if ($stockInvoice->invoice_type == 'GST') {

                        $cgstAmount = ($productSubTotal * $originalProduct['cgst_rate']) / 100;
                        $sgstAmount = ($productSubTotal * $originalProduct['sgst_rate']) / 100;

                        $totalCgst += $cgstAmount;
                        $totalSgst += $sgstAmount;

                        $returnedProducts[$productKey] = [
                            'product_id' => $productId,
                            'name' => $originalProduct['name'],
                            'batch_no' => $batchNo,
                            'quantity' => $quantityReturned,
                            'original_price' => $originalProduct['original_price'],
                            'price_after_discount' => $price,
                            'sub_total' => $productSubTotal,
                            'sub_totals' => $productSubTotals,
                            'cgst_rate' => $originalProduct['cgst_rate'],
                            'sgst_rate' => $originalProduct['sgst_rate'],
                            'cgst_amount' => $cgstAmount,
                            'sgst_amount' => $sgstAmount,
                            'discount_percentage' => $originalProduct['discount_percentage'],
                        ];
                    } elseif ($stockInvoice->invoice_type == 'Non_GST') {

                        $returnedProducts[$productKey] = [
                            'product_id' => $productId,
                            'name' => $originalProduct['name'],
                            'batch_no' => $batchNo,
                            'quantity' => $quantityReturned,
                            'original_price' => $originalProduct['original_price'],
                            'price_after_discount' => $price,
                            'sub_total' => $productSubTotal,
                            'sub_totals' => $productSubTotals,
                            'cgst_rate' => 0,
                            'sgst_rate' => 0,
                            'cgst_amount' => 0,
                            'sgst_amount' => 0,
                            'discount_percentage' => $originalProduct['discount_percentage'],
                        ];
                    }

                    $originalProducts[$productKey]['quantity'] -= $quantityReturned;

                    if ($originalProducts[$productKey]['quantity'] <= 0) {
                        unset($originalProducts[$productKey]);
                    }

                    $stock = Stocks::where('batch_no', $batchNo)->first();
                    if ($stock) {
                        $stock->stock += $quantityReturned;
                        $stock->save();

                        $variant = $stock->variant;
                        if ($variant) {
                            $variant->stock += $quantityReturned;
                            $variant->save();
                        }
                    } else {
                        return response()->json([
                            'error' => 'Batch not found for product ' . $originalProduct['name']
                        ], 404);
                    }
                } else {
                    return response()->json([
                        'error' => 'Product or batch not found in the original invoice for product ID: ' . $productId
                    ], 404);
                }
            }

            $stockInvoice->total_quantity -= $totalQuantityReturned;
            $stockInvoice->products = $originalProducts;
            $stockInvoice->save();

            if ($stockInvoice->invoice_type == 'GST') {
                $totalAmountWithGST = $subTotal + $totalCgst + $totalSgst;
            } else {
                $totalAmountWithGST = $subTotal;
            }

            $amountInWords = Helper::inwords($totalAmountWithGST);

            DB::commit();

            $returnInvoiceData = [
                'invoice_id' => $stockInvoice->invoice_no,
                'return_date' => $return_date,
                'invoice_type' => $stockInvoice->invoice_type,
                'customer_name' => $request->customer_name,
                'customer_phone' => $request->customer_phone,
                'customer_address' => $request->customer_address,
                'products' => $returnedProducts,
                'sub_total' => $subTotal,
                'sub_totals' => $subTotals,
                'total_quantity' => $totalQuantityReturned,
                'total_amount' => $totalAmountWithGST,
                'total_cgst' => $totalCgst,
                'total_sgst' => $totalSgst,
                'amount_in_words' => $amountInWords,
            ];

            // Save the return details in the StockProductReturn table
            StockProductReturn::create([
                'invoice_id' => $stockInvoice->invoice_no,
                'invoice_type' => $stockInvoice->invoice_type,
                'return_reason' => $request->returnReason,
                'return_date' => $return_date,
                'customer_phone' => $request->customer_phone,
                'customer_name' => $request->customer_name,
                'customer_address' => $request->customer_address,
                'place_of_supply' => $request->place_of_supply,
                'products' => json_encode($returnedProducts), // Store returned products as JSON
                'sub_totals' => $subTotals,
                'total_cgst' => $totalCgst,
                'total_sgst' => $totalSgst,
                'total_amount' => $totalAmountWithGST,
            ]);

            return response()->json([
                'success' => true,
                'returnInvoiceGenerateUrl' => route('stocks.returnInvoiceGenerate', ['data' => $returnInvoiceData]),
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'error' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }

    public function returnInvoiceGenerate(Request $request)
    {

        $invoiceData = $request->input('data');

        //  dd($invoiceData);

        return view('backend.stock.returnInvoiceGenerate', compact('invoiceData'));
    }

    public function new_sale_return()
    {
        return view('backend.stock.new_sale_return');
    }

    public function getProductBatches($productId)
    {
        $batches = Stocks::where('variant_id', $productId)
            ->where('stock', '>', 0)
            ->get(['id', 'batch_no', 'price', 'stock', 'expiry']); // Include 'stock' in the selection

        return response()->json(['batches' => $batches]);
    }
    public function getProductStock($stockId)
    {


        $stock = Stocks::where('id', $stockId)
            ->get('stock')->first(); // Include 'stock' in the selection
        return response()->json(['stock' => $stock]);
    }

    public function getProductPrice($id)
    {
        $variant = Variant::where('product_id', $id)->first();
        if ($variant) {
            return response()->json(['price' => $variant->price]);
        } else {
            return response()->json(['price' => 0]);
        }
    }

    public function generateInvoice(Request $request)
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

    public function generateInvoiceShow($invoice_no)
    {
        $invoiceData = StockInvoice::where('invoice_no', $invoice_no)->first();

        return view('backend.stock.invoice', compact('invoiceData'));
    }


    public function showinvoice()
    {
        $invoiceData = StockInvoice::get();
        // return $invoiceData;
        return view("backend.stock.offlineinvoice", compact('invoiceData'));
    }
    public function showinvoiceData(Request $request)
    {
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');
        $query = StockInvoice::query();

        if ($fromDate && $toDate) {
            $query->whereBetween('created_at', [Carbon::parse($fromDate), Carbon::parse($toDate)->endOfDay()]);
        } elseif ($fromDate) {
            $query->where('created_at', '>', Carbon::parse($fromDate));
        } elseif ($toDate) {
            $query->where('created_at', '<', Carbon::parse($toDate)->endOfDay());
        }


        $totalRecords = $query->count();
        $total = $query->sum('total_amount');
        $items = $query->skip($request->start)->take($request->length)->get();
        return [
            "data" => $items,
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => $totalRecords,
            "total" => $total,
        ];
    }

    public function trashInvoiceBill($id)
    {
        $invoice = StockInvoice::findOrFail($id);
        $invoice->delete();


        return redirect()->back()->with('success', 'Invoice trashed successfully.');
    }




    public function profileUpdate(Request $request, $id)
    {
        // return $request->all();
        $user = User::findOrFail($id);
        $data = $request->all();
        $status = $user->fill($data)->save();
        if ($status) {
            session()->flash('success', 'Successfully updated your profile');
        } else {
            session()->flash('error', 'Please try again!');
        }
        return redirect()->back();
    }

    public function settings()
    {
        $data = Settings::first();
        return view('backend.setting')->with('data', $data);
    }

    public function settingsUpdate(Request $request)
    {

        $data = $request->all();
        $settings1 = Settings::first();
        $status = $settings1->fill($data)->save();
        $settings = Settings::first();
        if ($status) {
            session()->flash('success', 'Setting successfully updated');
        } else {
            session()->flash('error', 'Please try again');
        }
        return redirect()->route('admin');
    }

    public function changePassword()
    {
        return view('backend.layouts.changePassword');
    }
    public function changPasswordStore(Request $request)
    {
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);

        Admin::find(auth()->guard('admin')->user()->id)->update(['password' => Hash::make($request->new_password)]);

        return redirect()->route('admin')->with('success', 'Password successfully changed');
    }
    public function login(Request $request)
    {
        return view('auth.login');
    }
    public function login_submit(Request $request)
    {

        $credentials = $request->only('email', 'password');
        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->intended('/admin'); // Redirect after successful login
        }

        return redirect()->back()->withErrors(['email' => 'Invalid credentials.']);
    }
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        return redirect()->back();
    }
    // Pie chart
    public function userPieChart(Request $request)
    {
        // dd($request->all());
        $data = User::select(DB::raw("COUNT(*) as count"), DB::raw("DAYNAME(created_at) as day_name"), DB::raw("DAY(created_at) as day"))
            ->where('created_at', '>', Carbon::today()->subDays(6))
            ->groupBy('day_name', 'day')
            ->orderBy('day')
            ->get();
        $array[] = ['Name', 'Number'];
        foreach ($data as $key => $value) {
            $array[++$key] = [$value->day_name, $value->count];
        }
        //  return $data;
        return view('backend.index')->with('course', json_encode($array));
    }

    public function storageLink()
    {
        // check if the storage folder already linked;
        if (File::exists(public_path('storage'))) {
            // removed the existing symbolic link
            File::delete(public_path('storage'));

            //Regenerate the storage link folder
            try {
                Artisan::call('storage:link');
                session()->flash('success', 'Successfully storage linked.');
                return redirect()->back();
            } catch (Exception $exception) {
                session()->flash('error', $exception->getMessage());
                return redirect()->back();
            }
        } else {
            try {
                Artisan::call('storage:link');
                session()->flash('success', 'Successfully storage linked.');
                return redirect()->back();
            } catch (Exception $exception) {
                session()->flash('error', $exception->getMessage());
                return redirect()->back();
            }
        }
    }

    public function centerUpdate()
    {
        $admin = Admin::with('center')->first();
        $centers = Center::all();
        return view('backend.adminSetting')->with([
            'admin' => $admin,
            'centers' => $centers,
        ]);
    }

    public function adminUpdate(Request $request)
    {

        $request->validate([
            'center_id' => 'required|exists:centers,id'
        ]);

        $admin = Admin::where('id', Auth::guard('admin')->id())->first();
        $admin->center_id = $request->center_id;
        $admin->save();
        return redirect()->route('admin')->with('success', 'Admin center updated successfully.');
    }

}
