<?php

namespace App\Http\Controllers;

use App\Models\Billing;
use App\Models\Product;

use Illuminate\Http\Request;

class BillingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $billing = Billing::get();

        // return $products;
        return view('backend.billing.index')->with('billing', $billing);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $product = Product::orderBy('id', 'DESC')->get();
        return view('backend.billing.create')->with('product', $product);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data['product'] = implode(',', $data['product']);
        $data['cgst'] = implode(',', $data['cgst']);
        $data['sgst'] = implode(',', $data['sgst']);
        $data['qty'] = implode(',', $data['qty']);
        $data['discount'] = $data['discount'];

        //$qty = $data['qty'];
        //    $product = Product::where('status','active')->where('id',$data['product'])->decrement('stock', $qty);

        $status = Billing::create($data);
        $billing = Billing::get();
        return view('backend.billing.index')->with('billing', $billing);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $billing = Billing::find($id);
        // return $order;
        return view('backend.billing.show')->with('billing', $billing);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
