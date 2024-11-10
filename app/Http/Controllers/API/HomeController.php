<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Concern;
use App\Models\Post;
use App\Models\Newctas;
use App\Models\ProductType;
use App\Models\Testimonial;
use App\Models\Social;
use App\Models\Banner;
use App\Models\Poster;
use App\Models\Promise;
use App\Models\Story;
use App\Models\Category;
use App\Models\Brand;


class HomeController extends Controller
{
    public function home(): JsonResponse
    {
        // Fetch data
        $featured = Product::where('status', 'active')
            ->where('is_featured', 1)
            ->where(function ($query) {
                $query->whereNull('combo')
                    ->orWhere('combo', 0);
            })
            ->orderBy('price', 'DESC')
            ->orderBy('created_at', 'DESC')
            ->limit(8)
            ->get();

        $combo = Product::where('status', 'active')
            ->where('combo', 1)
            ->orderBy('price', 'DESC')
            ->orderBy('created_at', 'DESC')
            ->limit(8)
            ->get();

        $concern = Concern::limit(8)->get();
        $posts = Post::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();
        $cta = Newctas::orderBy('id', 'DESC')->limit(1)->get();
        $product_type = ProductType::limit(8)->get();
        $testimonial = Testimonial::where('status', 'active')->orderBy('id', 'DESC')->get();
        $youtube = Social::where('social', 'youtube')->orderBy('id', 'DESC')->get();
        $instagram = Social::where('social', 'instagram')->orderBy('id', 'DESC')->get();
        $banners = Banner::where('status', 'active')->limit(3)->orderBy('id', 'DESC')->get();
        $posters1 = Poster::where('status', 'active')->where('page', 'home')->where('position', '1')->limit(1)->get();
        $posters2 = Poster::where('status', 'active')->where('page', 'home')->where('position', '2')->limit(1)->get();
        $promise = Promise::where('status', 'active')->orderBy('id', 'DESC')->get();
        $story = Story::limit(1)->orderBy('id', 'DESC')->get();
        $products = Product::where('status', 'active')->orderBy('id', 'DESC')->get();
        $category = Category::where('status', 'active')->where('is_parent', 1)->orderBy('title', 'ASC')->get();
        $brandid = Brand::where('status', 'active')->orderBy('title', 'ASC')->get();
        $concernid = Concern::where('status', 'active')->where('is_parent', 1)->orderBy('title', 'ASC')->limit(4)->get();
        $typeid = ProductType::where('status', 'active')->orderBy('title', 'ASC')->limit(4)->get();

        $cat_ids = $category->isNotEmpty() ? $category[0]->id : null;
        $brand_id = $brandid->isNotEmpty() ? $brandid[0]->id : null;
        $concern_id = $concernid->isNotEmpty() ? $concernid[0]->id : null;
        $type_id = $typeid->isNotEmpty() ? $typeid[0]->id : null;

        $cproducts = $products->whereIn('cat_id', [$cat_ids])->all();
        $bproducts = $products->whereIn('brand_id', [$brand_id])->all();
        $conproduct = $products->whereIn('concern_id', [$concern_id])->all();
        $ptype = $products->whereIn('ptype_id', [$type_id])->all();

        // Return response
        return response()->json([
            'status' => true,
            'message' => 'Data retrieved successfully',
            'data' => [
                'featured' => $featured,
                'combo' => $combo,
                'posts' => $posts,
                'testimonial' => $testimonial,
                'banners' => $banners,
                'product_lists' => $products,
                'category_lists' => $category,
                'cproducts' => $cproducts,
                'bproducts' => $bproducts,
                'conproduct' => $conproduct,
                'ptype' => $ptype,
                'promise' => $promise,
                'poster1' => $posters1,
                'concernid' => $concernid,
                'type' => $typeid,
                'youtube' => $youtube,
                'instagram' => $instagram,
                'cta' => $cta,
                'story' => $story,
                'poster2' => $posters2,
                'concern' => $concern,
                'product_type' => $product_type,
            ],
        ]);
    }
}
