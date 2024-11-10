<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Concern;
use App\Models\Product;
use App\Models\ProductType;
use Illuminate\Http\Request;

class Productcontroller extends Controller
{
    public function productDetail($slug)
    {
        // Retrieve product detail by slug
        $product_detail = Product::getProductBySlug($slug);

        // Fetch related data
        $ptype = ProductType::where('id', $product_detail->ptype_id)->first();
        $concern = Concern::where('id', $product_detail->concern_id)->first();
        $brand = Concern::where('id', $product_detail->brand_id)->first();

        // Fetch recent products
        $recent_products = Product::where('cat_id', $product_detail->cat_id)
            ->orderBy('id', 'DESC')
            ->limit(5)
            ->get();

        // Return JSON response
        return response()->json([
            'product_detail' => $product_detail,
            'recent_products' => $recent_products,
            'concern' => $concern,
            'ptype' => $ptype,
            'brand' => $brand,
        ]);
    }
    public function productSearch(Request $request)
    {
        $recent_products = Product::where('status', 'active')
            ->orderBy('id', 'DESC')
            ->limit(3)
            ->get();

        $products = Product::orWhere('title', 'like', '%' . $request->search . '%')
            ->orWhere('slug', 'like', '%' . $request->search . '%')
            ->orWhere('description', 'like', '%' . $request->search . '%')
            ->orWhere('summary', 'like', '%' . $request->search . '%')
            ->orWhere('price', 'like', '%' . $request->search . '%')
            ->orderBy('id', 'DESC')
            ->get();

        return response()->json([
            'products' => $products,
            'recent_products' => $recent_products,
        ]);
    }
    public function productCat(Request $request)
    {
        // Find category by slug
        $category = Category::where('slug', $request->slug)->first();

        // Check if category exists
        if (!$category) {
            return response()->json(['error' => 'Category not found'], 404);
        }

        $type = Category::where('slug', $request->slug)
            ->orderBy('title', 'ASC')
            ->get();

        $products = Product::where('status', 'active')
            ->where('cat_id', $category->id)
            ->orderBy('id', 'DESC')
            ->get();

        $recent_products = Product::where('status', 'active')
            ->orderBy('id', 'DESC')
            ->limit(3)
            ->get();

        return response()->json([
            'products' => $products,
            'recent_products' => $recent_products,
            'type' => $type,
        ]);
    }
    public function productSubCat(Request $request)
    {
        // Fetch products by sub-category
        $products = Category::getProductBySubCat($request->sub_slug);

        // Check if products exist
        if (!$products) {
            return response()->json(['error' => 'Products not found'], 404);
        }

        // Fetch type based on slug
        $type = Category::where('slug', $request->slug)
            ->orderBy('title', 'ASC')
            ->get();

        // Fetch recent products
        $recent_products = Product::where('status', 'active')
            ->orderBy('id', 'DESC')
            ->limit(3)
            ->get();

        return response()->json([
            'products' => $products->sub_products,
            'recent_products' => $recent_products,
            'type' => $type,
        ]);
    }
    public function productBrand(Request $request)
    {
        // Fetch products by brand
        $products = Brand::getProductByBrand($request->slug);

        // Check if products exist
        if (!$products) {
            return response()->json(['error' => 'Products not found'], 404);
        }

        // Fetch product types based on slug
        $type = ProductType::where('slug', $request->slug)
            ->orderBy('title', 'ASC')
            ->get();

        // Fetch recent products
        $recent_products = Product::where('status', 'active')
            ->orderBy('id', 'DESC')
            ->limit(3)
            ->get();

        return response()->json([
            'products' => $products->products, // Directly use the data without json_encode
            'recent_products' => $recent_products,
            'type' => $type,
        ]);
    }
    public function productType(Request $request)
    {
        // Fetch products by type
        $products = ProductType::getProductByType($request->slug);

        // Check if products exist
        if (!$products) {
            return response()->json(['error' => 'Products not found'], 404);
        }

        // Fetch product types based on slug
        $type = ProductType::where('slug', $request->slug)
            ->orderBy('title', 'ASC')
            ->get();

        // Fetch recent products
        $recent_products = Product::where('status', 'active')
            ->orderBy('id', 'DESC')
            ->limit(3)
            ->get();

        return response()->json([
            'products' => $products->products, // Use data directly without json_encode
            'recent_products' => $recent_products,
            'type' => $type,
        ]);
    }
    public function productConcern(Request $request)
    {
        // Fetch products by concern
        $products = Concern::getProductByConcern($request->slug);

        // Check if products exist
        if (!$products) {
            return response()->json(['error' => 'Products not found'], 404);
        }

        // Fetch concern types based on slug
        $type = Concern::where('slug', $request->slug)
            ->orderBy('title', 'ASC')
            ->get();

        // Fetch recent products
        $recent_products = Product::where('status', 'active')
            ->orderBy('id', 'DESC')
            ->limit(3)
            ->get();

        return response()->json([
            'products' => $products->products, // Directly use the data without json_encode
            'recent_products' => $recent_products,
            'type' => $type,
        ]);
    }
    public function productSubConcern(Request $request)
    {
        // Fetch products by sub-concern
        $products = Concern::getProductBySubConcern($request->sub_slug);

        // Check if products exist
        if (!$products) {
            return response()->json(['error' => 'Products not found'], 404);
        }

        // Fetch type based on slug
        $type = Category::where('slug', $request->slug)
            ->orderBy('title', 'ASC')
            ->get();

        // Fetch recent products
        $recent_products = Product::where('status', 'active')
            ->orderBy('id', 'DESC')
            ->limit(3)
            ->get();

        return response()->json([
            'products' => $products->sub_products, // Use data directly without json_encode
            'recent_products' => $recent_products,
            'type' => $type,
        ]);
    }
    public function AllCategory()
    {
        // Fetch categories
        $type = Category::getCategory();

        // Fetch recent products
        $recent_products = Product::where('status', 'active')
            ->orderBy('id', 'DESC')
            ->limit(3)
            ->get();

        $title = 'Category';
        $href = "product-sub-categories/";

        return response()->json([
            'type' => $type->data ?? $type, // Use 'data' if available, otherwise use the full type
            'recent_products' => $recent_products,
            'title' => $title,
            'href' => $href,
        ]);
    }
    public function AllConcern()
    {
        // Fetch concerns
        $type = Concern::getConcern();

        // Fetch recent products
        $recent_products = Product::where('status', 'active')
            ->orderBy('id', 'DESC')
            ->limit(3)
            ->get();

        $title = 'Concern';
        $href = "product-sub-concerns/";

        return response()->json([
            'type' => $type->data ?? $type, // Use 'data' if available, otherwise use the full type
            'recent_products' => $recent_products,
            'title' => $title,
            'href' => $href,
        ]);
    }
    public function AllBrand()
    {
        // Fetch all brands
        $type = Brand::getAllBrand();

        // Fetch recent products
        $recent_products = Product::where('status', 'active')
            ->orderBy('id', 'DESC')
            ->limit(3)
            ->get();

        $title = 'Brand';
        $href = "product-brand/";

        return response()->json([
            'type' => $type->data ?? $type, // Use 'data' if available, otherwise use the full type
            'recent_products' => $recent_products,
            'title' => $title,
            'href' => $href,
        ]);
    }
    public function AllType()
    {
        // Fetch all product types
        $type = ProductType::getType();

        // Fetch recent products
        $recent_products = Product::where('status', 'active')
            ->orderBy('id', 'DESC')
            ->limit(3)
            ->get();

        $title = 'Product-Type';
        $href = "product-type/";

        return response()->json([
            'type' => $type->data ?? $type, // Use 'data' if available, otherwise return the full type
            'recent_products' => $recent_products,
            'title' => $title,
            'href' => $href,
        ]);
    }
    public function AllSubCategory(Request $request)
    {
        // Fetch all sub-categories based on the provided slug
        $type = Category::getAllSubCategory($request->slug);

        // Check if type data exists
        if (!$type) {
            return response()->json(['error' => 'Sub-categories not found'], 404);
        }

        // Fetch recent products
        $recent_products = Product::where('status', 'active')
            ->orderBy('id', 'DESC')
            ->limit(3)
            ->get();

        $title = 'Category1';
        $href = "product-sub-cat/";

        return response()->json([
            'type' => $type->data ?? $type, // Use 'data' if available, otherwise return the full type
            'recent_products' => $recent_products,
            'title' => $title,
            'href' => $href,
        ]);
    }
    public function AllSubConcern(Request $request)
    {
        // Fetch all sub-concerns based on the provided slug
        $type = Concern::getAllSubConcern($request->slug);

        // Check if type data exists
        if (!$type) {
            return response()->json(['error' => 'Sub-concerns not found'], 404);
        }

        // Fetch recent products
        $recent_products = Product::where('status', 'active')
            ->orderBy('id', 'DESC')
            ->limit(3)
            ->get();

        $title = 'Concern';
        $href = "product-sub-concern/";

        return response()->json([
            'type' => $type->data ?? $type, // Use 'data' if available, otherwise return the full type
            'recent_products' => $recent_products,
            'title' => $title,
            'href' => $href,
        ]);
    }
    public function AllSubBrand(Request $request)
    {
        // Fetch child brands based on the provided slug
        $type = Brand::getChildByParentID($request->slug);

        // Check if type data exists
        if (!$type) {
            return response()->json(['error' => 'Sub-brands not found'], 404);
        }

        // Fetch recent products
        $recent_products = Product::where('status', 'active')
            ->orderBy('id', 'DESC')
            ->limit(3)
            ->get();

        $title = 'Brand';
        $href = "product-brand/";

        return response()->json([
            'type' => $type->data ?? $type, // Use 'data' if available, otherwise return the full type
            'recent_products' => $recent_products,
            'title' => $title,
            'href' => $href,
        ]);
    }
    public function AllSubType(Request $request)
    {
        // Fetch child product types based on the provided slug
        $type = ProductType::getChildByParentID($request->slug);

        // Check if type data exists
        if (!$type) {
            return response()->json(['error' => 'Sub-types not found'], 404);
        }

        // Fetch recent products
        $recent_products = Product::where('status', 'active')
            ->orderBy('id', 'DESC')
            ->limit(3)
            ->get();

        $title = 'Product-sub-Type';
        $href = "product-sub-type/";

        return response()->json([
            'type' => $type->data ?? $type, // Use 'data' if available, otherwise return the full type
            'recent_products' => $recent_products,
            'title' => $title,
            'href' => $href,
        ]);
    }
    public function logoutApi(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logged out']);
    }
}
