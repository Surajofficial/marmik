<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductsRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Strep;
use App\Models\Concern;
use App\Models\ProductType;
use GuzzleHttp\Handler\Proxy;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      
        $products = Product::getAllProduct();

        // return $products;
        return view('backend.product.index')->with('products', $products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        $brands = Brand::get();
        $strep = Strep::get();

        $concerns = Concern::where('is_parent', 1)->get();
        $ptypes = ProductType::where('is_parent', 1)->get();
        $categories = Category::where('is_parent', 1)->get();
        return view('backend.product.create', compact('categories', 'brands', 'concerns', 'ptypes', 'strep'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductsRequest $request)
    {

        if ($request->filled('buy_x') && $request->filled('get_y')) {
            $rules = [
                'buy_x' => $request->input('buy_x'),
                'get_y' => $request->input('get_y'),
            ];
            $data['rules'] = $rules;
        }
        $data = $request->all();

        if ($request->hasFile('video')) {
            $video = $request->file('video');
            $input = time() . "." . $video->getClientOriginalExtension();
            $destinationPath = 'assets/uploads/';
            $video->move($destinationPath, $input);
            $data['video'] = $input;
        }

        $slug = Str::slug($request->title);
        $count = Product::where('slug', $slug)->count();
        if ($count > 0) {
            $slug = $slug . '-' . date('ymdis') . '-' . rand(0, 999);
        }
        $data['slug'] = $slug;
        $data['is_featured'] = $request->input('is_featured', 0);
        $data['presc'] = $request->input('presc', 0);
        $data['combo'] = $request->input('combo', 0);

        $data['concern_id'] = null; // Default to null
        $data['cat_id'] = null; // Default to null
        $data['ptype_id'] = null; // Default to null

        $product = Product::create($data);

        if ($request->has('ptype_id')) {
            $product->productTypes()->attach($request->input('ptype_id'));
        }

        if ($request->has('concern_id')) {
            $product->concerns()->attach($request->input('concern_id'));
        }

        if ($request->has('cat_id')) {
            $product->categories()->attach($request->input('cat_id'));
        }

        if ($product) {
            session()->flash('success', 'Product Successfully added');
        } else {
            session()->flash('error', 'Please try again!!');
        }

        return redirect()->route('product.index');
    }



    public function edit($id): View
    {
        $product = Product::findOrFail($id);
        $brands = Brand::get();
        $categories = Category::where('is_parent', 1)->get();
        $strep = Strep::get();
        $concerns = Concern::where('is_parent', 1)->get();
        $ptypes = ProductType::where('is_parent', 1)->get();
        return view('backend.product.create', compact('product', 'brands', 'categories', 'strep', 'concerns', 'ptypes'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductsRequest $request, $id)
    {

        $product = Product::findOrFail($id);
        $data = $request->except(['cat_id', 'concern_id', 'ptype_id', 'video']);

        $data['is_featured'] = $request->input('is_featured', 0);
        $data['presc'] = $request->input('presc', 0);
        $data['combo'] = $request->input('combo', 0);
        if ($request->filled('buy_x') && $request->filled('get_y')) {
            $rules = [
                'buy_x' => $request->input('buy_x'),
                'get_y' => $request->input('get_y'),
            ];
            $data['rules'] = $rules;
        }
        if ($request->hasFile('video')) {
            $video = $request->file('video');
            $input = time() . "." . $video->getClientOriginalExtension();
            $destinationPath = 'assets/uploads/';
            $video->move($destinationPath, $input);
            $data['video'] = $input;
        }

        $product->fill($data);
        $status = $product->save();

        if ($status) {
            // Update relationships
           
            $product->categories()->sync($request->cat_id);
            $product->concerns()->sync($request->concern_id);
            if ($request->has('ptype_id')) {
                for ($i = 0; $i < count($request->ptype_id); $i++) {
                    $product->productTypes()->sync($request->ptype_id[$i]);
                }
            }
            $product->ptypes()->sync($request->ptype_id);
            session()->flash('success', 'Product Successfully updated');
        } else {
            session()->flash('error', 'Please try again!!');
        }
        return redirect()->route('product.index');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $status = $product->delete();

        if ($status) {
            session()->flash('success', 'Product successfully deleted');
        } else {
            session()->flash('error', 'Error while deleting product');
        }
        return redirect()->route('product.index');
    }
}
