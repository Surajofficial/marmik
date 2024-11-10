<?php

namespace App\Http\Controllers;

use App\Http\Requests\StockRequest;
use App\Models\Center;
use App\Models\StockeHistory;
use App\Models\Stocks;
use App\Models\Strep;
use App\Models\Variant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StocksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $centers = Center::all();
        $stocks = Stocks::with('product')->with('variant')->with('strep')->with('center')->get();
        // return $stocks;
        return view("backend.stock.index", compact('stocks', 'centers'));
    }


    public function buy()
    {
        dd("hello");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $varients = Variant::with('product')->with('strep')->get();
        $strep = Strep::get();
        $centers = Center::get();
        return view('backend.stock.form', compact('varients', 'strep', 'centers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StockRequest $request)
    {
        $data = $request->validated();

        $stock = Stocks::create($data);
        $totalStock = Stocks::where('variant_id', $stock->variant_id)->sum('stock');
        Variant::where('id', $stock->variant_id)->update(['stock' => $totalStock]);
        return redirect()->route('stocks.index')->with('success', 'Stock added successfully');
    }

    /** 
     * Display the specified resource.
     */
    public function show(Stocks $stocks)
    {
        // return 'test';
    }

    // batch number 
    public function getStockByBatch(Request $request)
    {
        $request->validate([
            'batch_number' => 'required|string|max:255',
            'cityId' => 'required|integer'
        ]);

        $batchNumber = $request->input('batch_number');
        $cityId = $request->input('cityId');
        // dd($cityName);

        // $stocks = Stocks::where('batch_no', $batchNumber)->with('product', 'center')->get();

        $stocks = Stocks::where('batch_no', $batchNumber)
            ->where('center_id', $cityId)
            ->with('product', 'center')
            ->get();

        return response()->json($stocks);
    }

    // add Stock
    public function addStock(Request $request)
    {
        $validated = $request->validate([
            'batch_number' => 'required|string',
            'quantity' => 'required|integer',
            'cityId' => 'required|integer'
        ]);

        // Find the stock entry by batch number
        $stock = Stocks::where('batch_no', $validated['batch_number'])->where('center_id', $validated['cityId'])->first();

        if ($stock) {

            $stock->stock += $validated['quantity'];
            $stock->save();
            $variant = Variant::where('id', $stock->variant_id)->first();
            $variant->stock += $validated['quantity'];
            $variant->save();
            $name = Auth::guard('admin')->user()->name;
            $batch_number = $validated['batch_number'];
            StockeHistory::create([
                'user_id' => Auth::guard('admin')->user()->id,
                'stock_id' => $stock->id,
                'comment' => "Stock added by $name In batch number $batch_number",
            ]);

            
            $variant = Variant::where('product_id',$stock->variant_id)->first();

            if ($validated['quantity'] > 0) {
                $variant->stock += $validated['quantity'];
                $variant->save();
            } 
            $totalStock = Stocks::where('variant_id', $stock->variant_id)->sum('stock');
    
            Variant::where('id', $stock->variant_id)->update(['stock' => $totalStock]);
            

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Stock not found'], 404);
    }

    //remove stock
    public function removeStock(Request $request)
    {
        $validated = $request->validate([
            'batch_number' => 'required|string',
            'quantity' => 'required|integer',
            'cityId' => 'required|integer'
        ]);

        $stock = Stocks::where('batch_no', $validated['batch_number'])->where('center_id', $validated['cityId'])->first();

        if ($stock) {
            if ($stock->stock < $validated['quantity']) {
                return response()->json(['success' => false, 'message' => 'Insufficient stock to remove.'], 400);
            }
            $name = Auth::guard('admin')->user()->name;
            $batch_number = $validated['batch_number'];
            StockeHistory::create([
                'user_id' => Auth::guard('admin')->user()->id,
                'stock_id' => $stock->id,
                'comment' => "Stock remove by $name In batch number $batch_number",
            ]);

            $stock->stock -= $validated['quantity'];
            $stock->save();

            $variant = Variant::where('id', $stock->variant_id)->first();
            $variant->stock -= $validated['quantity'];
            $variant->save();
            $variant = Variant::where('product_id', $stock->variant_id)->first();

            if ($validated['quantity'] > 0) {
                
                if ($variant->stock >= $validated['quantity']) {

                    $variant->stock -= $validated['quantity'];
                    $variant->save();
                } 
            } 
            $totalStock = Stocks::where('variant_id', $stock->variant_id)->sum('stock');
    
            Variant::where('id', $stock->variant_id)->update(['stock' => $totalStock]);
            

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Stock not found'], 404);
    }







    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Stocks $stock)
    {
        // return $stock;
        $varients = Variant::with('product')->with('strep')->get();
        $strep = Strep::get();
        $centers = Center::get();
        return view('backend.stock.form', compact('varients', 'strep', 'stock', 'centers'));
        ;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StockRequest $request, Stocks $stock)
    {
        $data = $request->validated();

        $stock->update($data);
        $totalStock = Stocks::where('variant_id', $stock->variant_id)->sum('stock');
        Variant::where('id', $stock->variant_id)->update(['stock' => $totalStock]);
        return redirect()->route('stocks.index')->with('success', 'Stock Update Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Stocks $stock)
    {
        //
        $stock->delete();
        return redirect()->back();
    }
}
