<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductVariantRequest;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Variant;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Strep;
use App\Models\Concern;
use App\Models\ProductType;
use Illuminate\Contracts\View\View;

class VariantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View
    {
        $variants = Variant::getAllVariant();
        return view('backend.variants.index', compact('variants'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        $brand = Brand::get();
        $strep = Strep::get();
        $product = Product::get();
        $category = Category::where('is_parent', 1)->get();
        $concern = Concern::where('is_parent', 1)->get();
        $ptype = ProductType::where('is_parent', 1)->get();
        $category = Category::where('is_parent', 1)->get();
        // return $category;
        return view('backend.variants.form')->with('categories', $category)->with('products', $product)->with('brands', $brand)->with('Concerns', $concern)->with('Ptype', $ptype)->with('strep', $strep);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductVariantRequest $request)
    {
        $data = $request->all();
        if ($request->filled('buy_x') && $request->filled('get_y')) {
            $rules = [
                'buy_x' => $request->input('buy_x'),
                'get_y' => $request->input('get_y'),
            ];
            $data['rules'] = json_encode($rules);
        }
        $data['is_featured'] = $request->input('is_featured', 0);
        $data['is_best_seller'] = $request->input('is_best_seller', 0);
        $status = Variant::create($data);
        if ($status) {
            session()->flash('success', 'Product Successfully added');
        } else {
            session()->flash('error', 'Please try again!!');
        }
        return redirect()->route('variant.index');

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Variant $variant): View
    {
        $products = Product::get();
        //   dd($product);
        $category = Category::where('is_parent', 1)->get();
        $strep = Strep::get();
        // dd($product->size);
        $concern = Concern::where('is_parent', 1)->get();
        $ptype = ProductType::where('is_parent', 1)->get();
        // return $items;
        return view('backend.variants.form', compact('variant', 'strep', 'products'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductVariantRequest $request, Variant $variant)
    {

        $data = $request->all();
        if ($request->filled('buy_x') && $request->filled('get_y')) {
            $rules = [
                'buy_x' => $request->input('buy_x'),
                'get_y' => $request->input('get_y'),
            ];
            $data['rules'] = json_encode($rules);
        }
        $data['is_featured'] = $request->input('is_featured', 0);
        $data['is_best_seller'] = $request->input('is_best_seller', 0);
        $status = $variant->update($data);
        if ($status) {
            session()->flash('success', 'Product Successfully updated');
        } else {
            session()->flash('error', 'Please try again!!');
        }
        return redirect()->route('variant.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Variant::findOrFail($id);
        $status = $product->delete();

        if ($status) {
            session()->flash('success', 'Product successfully deleted');
        } else {
            session()->flash('error', 'Error while deleting product');
        }
        return redirect()->route('variant.index');
    }
    public function ShowVariant(Request $request)
    {
        $variant = Variant::find($request->id);
        return json_encode($variant);
    }

}
