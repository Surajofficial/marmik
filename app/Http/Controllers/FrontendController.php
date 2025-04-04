<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Product;
use App\Models\Category;
use App\Models\PostTag;
use App\Models\PostCategory;
use App\Models\Post;
use App\Models\Cart;
use App\Models\Brand;
use App\Models\CertfiedBy;
use App\Models\Concern;
use App\Models\Information;
use App\Models\ProductType;
use App\Models\Promise;
use App\Models\Shopping;
use App\Models\Order;
use App\Models\Wishlist;
use App\Models\Routine;
use App\Models\Story;
use App\Models\Testimonial;
use App\Models\UserRoutine;
use App\Models\User;
use App\Models\Variant;
use App\Models\Couponnew;
use App\Models\DiscountedPurchase;
use App\Models\Store;
use App\Models\Terms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\Services\ProductService;
use Illuminate\Support\Facades\File;



class FrontendController extends Controller
{

    public function index(Request $request)
    {
        return redirect()->route($request->user()->role);
    }


    public function home()
    {

        $banners = Banner::where('status', 'active')->limit(3)->orderBy('id', 'DESC')->get(['photo']);
        $stores = Store::where('status', 'active')->orderBy('id', 'ASC')->get(['title', 'address', 'locationurl']);

        $select_field = ['id', 'price', 'discount', 'product_id', 'stock', 'fearured_no', 'best_seller_no', 'special_price'];
        // for featured products
        $featured = Variant::with(['product:id,photo,slug,title'])->where('status', 'active')->where('is_featured', 1)->orderBy('fearured_no', 'DESC')->limit(8)->distinct('product_id')->get($select_field);
        foreach ($featured as $product) {
            $product->display_price = $this->getprice($product);
        }
        // return ($featured);
        $best_seller = Variant::with(['product:id,photo,slug,title'])->where('status', 'active')->where('is_best_seller', 1)->orderBy('best_seller_no', 'DESC')->limit(8)->distinct('product_id')->get($select_field);
        foreach ($best_seller as $product) {
            $product->display_price = $this->getprice($product);
        }
        $concern = Concern::limit(8)->get(['photo', 'slug', 'title']);
        $product_type = ProductType::where('status', 'active')->limit(8)->get(['photo', 'slug', 'title']);

        $promise = Promise::where('status', 'active')->orderBy('id', 'DESC')->get(['photo', 'title']);
        $discount30 = Variant::with(['product:id,photo,slug,title'])->where('status', 'active')->where('discount', '<=', 30)->orderBy('price', 'DESC')->orderBy('discount', 'ASC')->orderBy('created_at', 'DESC')->limit(8)->get($select_field);
        foreach ($discount30 as $product) {
            $product->display_price = $this->getprice($product);
        }
        $all_products = Variant::with(['product:id,photo,slug,title'])->where('status', 'active')->orderBy('price', 'DESC')->orderBy('created_at', 'DESC')->get($select_field);

        // Filter the products where final price is less than 500
        $under499 = $all_products->filter(function ($product) {
            $discount_amount = $product->price * ($product->discount / 100);
            $final_price = $product->price - $discount_amount;
            return $final_price < 500;
        })->take(8);
        foreach ($under499 as $product) {
            $product->display_price = $this->getprice($product);
        }
        $testimonial = Testimonial::where('status', 'active')->orderBy('id', 'DESC')->get(['photo', 'title', 'description']);
        $info = Information::get(['info']);
        $story = Story::orderBy('id', 'DESC')->get(['photo', 'title', 'description'])->first();
        $certified = CertfiedBy::where('status', 'active')->orderBy('id', 'DESC')->get(['photo']);
        // return $featured;
        $wishlist_ids = [];
        if (Auth::check()) {
            $wishlist_ids = Auth::guard('web')->user()->wishlists()->pluck('product_id')->toArray();
        }
        return view('frontend.index', compact(
            'banners',
            'featured',
            'best_seller',
            'concern',
            'product_type',
            'promise',
            'discount30',
            'under499',
            'testimonial',
            'info',
            'story',
            'certified',
            'stores',
            'wishlist_ids'
        ));

    }
    public static function getprice($product)
    {
        $auth = Auth::guard('web')->user();
        if ($product->special_price != 0) {
            if ($auth) {
                // Check if the user has already purchased this product at a discount
                $purchase = DiscountedPurchase::where('user_id', $auth->id)
                    ->where('product_variants_id', $product->id)
                    ->first();
                if ($purchase) {
                    $product->display_price = $product->price; // Set original price
                } else {
                    $product->display_price = $product->special_price; // Set discounted price
                }
            } else {
                $product->display_price = $product->special_price;
            }
        } else {
            $product->display_price = $product->price;
        }
        return $product->display_price;
    }

    public function aboutUs()
    {
        return view('frontend.pages.about-us');
    }


    public function terms()
    {
        $terms = Terms::get();
        return $terms;
        return view('frontend.pages.terms', compact('terms'));
    }
    public function story()
    {
        return view('frontend.pages.story');
    }
    public function returns()
    {
        return view('frontend.pages.returns');
    }
    public function faq()
    {
        return view('frontend.pages.faq');
    }


    public function account()
    {
        if (auth()->guard('web')->user() == null) {
            return redirect()->route('login.form');
        }
        $orders = Order::where('user_id', auth()->guard('web')->user()->id)->orderBy('id', 'DESC')->paginate(10);
        // return $orders;
        $featured = Variant::with(['product:id,photo,slug,title'])
            ->where('status', 'active')  // Only active variants
            ->whereHas('wishlists', function ($query) {
                $query->where('user_id', Auth::id());  // Filter only wishlisted variants for the current user
            })
            ->orderBy('created_at', 'DESC')  // Order by creation date
            ->distinct('product_id')  // Get distinct products
            // ->paginate(5);  // Ensure you paginate instead of using get()
            ->get();


        foreach ($featured as $product) {
            $product->display_price = $this->getprice($product);
        }

        $featured = $featured ?: [];
        $userId = Auth::guard('web')->user()->id;
        $wishlist = Wishlist::where('user_id', $userId)->orderBy('id', 'DESC')->paginate(10);
        $wishlistCount = Wishlist::where('user_id', $userId)->count();
        $shipping = Shopping::where("user_id", $userId)->first();
        // return $orders;

        // Fetch all used coupons by the authenticated user
        $usedCoupons = Couponnew::whereHas('users', function ($query) use ($userId) {
            $query->where('user_id', $userId)
                ->whereNotNull('used_at'); // Only include coupons that have been used by the user
        })->get();


        // dd($usedCoupons);
        // dd($shipping);
        return view('frontend.pages.account', compact('shipping', 'orders', 'usedCoupons', 'featured', 'wishlist', 'wishlistCount'));
    }

    public function history()
    {
        $orders = Order::where('user_id', auth()->guard('web')->user()->id)->orderBy('id', 'DESC')->paginate(10);
        return view('frontend.pages.order-history')->with('orders', $orders);
    }

    public function payments(Request $request)
    {
        $cart = Cart::orderBy('id', 'DESC')->paginate(10);
        $data = $request->all();
        // dd($data);
        if (isset($data['presc'])) {
            $presc = $data['presc'];
            $input = time() . "." . $presc->getClientOriginalExtension();
            $destinationPath = 'assets/prescription/';
            $presc->move($destinationPath, $input);
            $data['presc'] = $input;
        }
        $price = (float) $data['tprice'];
        if (isset($data['tprice']) && is_numeric($data['tprice'])) {
            $price = round(floatval($data['tprice']) * 100);
        } else {
            return redirect()->back()->withErrors(['tprice' => 'Invalid total price']);
        }
        return view('frontend.pages.payment')->with('data', $data)->with('price', $price)->with('reward', $data['reward']);
    }



    public function order()
    {
        return view('frontend.pages.order-track');
    }

    public function contact()
    {
        return view('frontend.pages.contact');
    }

    public function routine()
    {
        $routine = Routine::orderBy('id', 'DESC')->get();


        return view('frontend.pages.routine')->with('routine', json_encode($routine));
    }

    public function productDetail($slug, $id = 0)
    {

        $product_detail = Product::getProductBySlug($slug);

        $product = Variant::with([
            'batches' => function ($query) {
                $query->where('stock', '>', 0)
                    ->orderBy('expiry', 'ASC')
                    ->orderBy('mfg', 'ASC')->first(); // Optional: further order by manufacturing date if needed
            }
        ]);

        $product = ($id == 0) ? $product->get()->first() : $product->where('id', $id)->get()->first();
        $product->display_price = $this->getprice($product);
        // return $product;
        $variant = $product_detail->variants;

        // return $product;
        $ptype = ProductType::where('id', $product_detail->ptype_id)->get();
        $concern = Concern::where('id', $product_detail->concern_id)->get();
        $brand = Concern::where('id', $product_detail->brand_id)->get();
        $recent_products = Product::where('cat_id', $product_detail['cat_id'])->orderBy('id', 'DESC')->limit(5)->get();
        $recent_products = Variant::with(['product:id,cat_id,photo,title,slug'])->where('status', 'active')
            ->whereHas('product', function ($query) use ($product_detail) {
                $query->where('cat_id', $product_detail['cat_id']);
            })
            ->get(['id', 'product_id', 'discount', 'price', 'stock'])->take(8);

        $wishlist_ids = [];
        if (Auth::check()) {
            $wishlist_ids = Auth::guard('web')->user()->wishlists()->pluck('product_id')->toArray();
        }

        return view('frontend.pages.product_detail', compact('variant', 'product', 'wishlist_ids'))->with('product_detail', $product_detail)->with('recent_products', $recent_products)->with('concern', $concern)->with('ptype', $ptype)->with('brand', $brand);
    }

    public function productGrids()
    {
        $products = Product::with('maxPriceVariant:id,product_id,discount,price,stock');

        if (!empty($_GET['category'])) {
            $slug = explode(',', $_GET['category']);
            // dd($slug);
            $cat_ids = Category::select('id')->whereIn('slug', $slug)->pluck('id')->toArray();
            // dd($cat_ids);
            $products->whereIn('cat_id', $cat_ids);
            // return $products;
        } else if (!empty($_GET['brand'])) {
            $slugs = explode(',', $_GET['brand']);
            $brand_ids = Brand::select('id')->whereIn('slug', $slugs)->pluck('id')->toArray();
            // return $brand_ids;
            $products->whereIn('brand_id', $brand_ids);
        } else if (!empty($_GET['sortBy'])) {
            if ($_GET['sortBy'] == 'title') {
                $products = $products->where('status', 'active')->orderBy('title', 'ASC');
            }
            if ($_GET['sortBy'] == 'price') {
                $products = $products->orderBy('price', 'ASC');
            }
        } else if (!empty($_GET['price'])) {
            $price = explode('-', $_GET['price']);
            $products->whereBetween('price', $price);
        }

        $recent_products = Product::with('maxPriceVariant:id,product_id,discount,price,stock')->whereHas('maxPriceVariant', function ($query) {
            $query->where('status', 'active');
        })->orderBy('id', 'DESC')->limit(3)->get();
        // Sort by number
        if (!empty($_GET['show'])) {
            $products = $products->whereHas('maxPriceVariant', function ($query) {
                $query->where('status', 'active');
            })->paginate(10);
        } else {
            $products = $products->whereHas('maxPriceVariant', function ($query) {
                $query->where('status', 'active');
            })->paginate(10);
        }
        $products1 = Product::whereHas('maxPriceVariant', function ($query) {
            $query->where('status', 'active');
        })->get();

        $wishlist_ids = [];
        if (Auth::check()) {
            $wishlist_ids = Auth::guard('web')->user()->wishlists()->pluck('product_id')->toArray();
        }
        return view('frontend.pages.product-grids', compact('wishlist_ids'))->with('products', json_encode($products1))->with('recent_products', $recent_products);
    }
    public function productLists()
    {
        $products = Product::with('maxPriceVariant:id,product_id,discount,price,stock')->query()
            ->orderBy('id', 'DESC')

        ;
        // dd($products);

        if (!empty($_GET['category'])) {
            $slug = explode(',', $_GET['category']);
            // dd($slug);
            $cat_ids = Category::select('id')->whereIn('slug', $slug)->pluck('id')->toArray();
            // dd($cat_ids);
            $products->whereIn('cat_id', $cat_ids)->paginate;
            // return $products;
        }
        if (!empty($_GET['brand'])) {
            $slugs = explode(',', $_GET['brand']);
            $brand_ids = Brand::select('id')->whereIn('slug', $slugs)->pluck('id')->toArray();
            // return $brand_ids;
            $products->whereIn('brand_id', $brand_ids);
        }
        if (!empty($_GET['sortBy'])) {
            if ($_GET['sortBy'] == 'title') {
                $products = $products->where('status', 'active')->orderBy('title', 'ASC');
            }
            if ($_GET['sortBy'] == 'price') {
                $products = $products->orderBy('price', 'ASC');
            }
        }

        if (!empty($_GET['price'])) {
            $price = explode('-', $_GET['price']);
            // return $price;
            // if(isset($price[0]) && is_numeric($price[0])) $price[0]=floor(Helper::base_amount($price[0]));
            // if(isset($price[1]) && is_numeric($price[1])) $price[1]=ceil(Helper::base_amount($price[1]));

            $products->whereBetween('price', $price);
        }
        $recent_products = Product::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();
        // Sort by number
        if (!empty($_GET['show'])) {
            $products = $products->whereHas('maxPriceVariant', function ($query) {
                $query->where('status', 'active');
            })->paginate($_GET['show']);
        } else {
            $products = $products->whereHas('maxPriceVariant', function ($query) {
                $query->where('status', 'active');
            })->paginate($_GET['show']);
        }
        // Sort by name , price, category

        // $products=json_encode($products);
        //return $products;
        return view('frontend.pages.product-lists')->with('products', $products)->with('recent_products', $recent_products);
    }
    public function productFilter(Request $request)
    {
        $data = $request->all();

        // return $data;
        $showURL = "";
        if (!empty($data['show'])) {
            $showURL .= '&show=' . $data['show'];
        }

        $sortByURL = '';
        if (!empty($data['sortBy'])) {
            $sortByURL .= '&sortBy=' . $data['sortBy'];
        }

        $catURL = "";
        if (!empty($data['category'])) {
            foreach ($data['category'] as $category) {
                if (empty($catURL)) {
                    $catURL .= '&category=' . $category;
                } else {
                    $catURL .= ',' . $category;
                }
            }
        }

        $brandURL = "";
        if (!empty($data['brand'])) {
            foreach ($data['brand'] as $brand) {
                if (empty($brandURL)) {
                    $brandURL .= '&brand=' . $brand;
                } else {
                    $brandURL .= ',' . $brand;
                }
            }
        }
        // return $brandURL;

        $priceRangeURL = "";
        if (!empty($data['price_range'])) {
            $priceRangeURL .= '&price=' . $data['price_range'];
        }

        return redirect()->route('product-grids', $catURL . $brandURL . $priceRangeURL . $showURL . $sortByURL);
        // if(request()->is('Dr Awish.loc/product-grids')){

        // }
        // else{
        //     return redirect()->route('product-lists',$catURL.$brandURL.$priceRangeURL.$showURL.$sortByURL);
        // }
    }
    // public function productSearch(Request $request)
    // {
    //     $products = Product::with('maxPriceVariant:id,product_id,discount,price,stock')
    //         ->where(function ($query) use ($request) {
    //             $query->orWhere('title', 'like', '%' . $request->search . '%')
    //                 ->orWhere('slug', 'like', '%' . $request->search . '%')
    //                 ->orWhere('description', 'like', '%' . $request->search . '%')
    //                 ->orWhere('summary', 'like', '%' . $request->search . '%');
    //         })
    //         ->orWhereHas('variants', function ($query) use ($request) {
    //             $query->where('price', 'like', '%' . $request->search . '%');
    //         })
    //         ->orderBy('id', 'DESC')
    //         ->get(['id', 'photo', 'title', 'slug']);
    //     $products = json_encode($products);
    //     return view('frontend.pages.product-grids', compact('products'));
    // }
    public function productSearch(Request $request, ProductService $productService)
    {
        // Validate the search input
        $request->validate([
            'q' => 'required|string|min:1|max:255'
        ]);

        // Get the search term
        $searchTerm = $request->input('q');

        // Use the ProductService to fetch the products
        $products = $productService->searchProducts($searchTerm);

        // Check if products were found; if not, return an empty array
        if ($products->isEmpty()) {
            $products = []; // Set to empty array if no products found
        } else {
            // Optionally you can convert the products collection to an array or JSON if needed
            $products = $products->toArray(); // Convert to array for better handling in JS
        }
        $products = json_encode($products);
        // Return the view with the products data
        return view('frontend.pages.product-grids', compact('products'));
    }


    public function productBrand(Request $request)
    {
        $products = Brand::getProductByBrand($request->slug);
        $products = json_encode($products->products);
        $type = ProductType::where('slug', $request->slug)->orderBy('title', 'ASC')->get();
        $recent_products = Product::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();
        return view('frontend.pages.product-grids')->with('products', $products)->with('recent_products', $recent_products)->with('type', $type);
    }

    public function productType(Request $request)
    {
        $products = ProductType::getProductByType($request->slug);
        // if (Auth::guard('admin')->check()) {
        //     return $products;
        // }
        $type = $products->title;
        $summary = $products->summary;
        // if (Auth::guard('admin')->check()) {
        //     return $products;
        // }
        $products = json_encode($products->products);
        return view('frontend.pages.product-grids', compact('summary', 'type', 'products'));
    }

    public function productConcern(Request $request)
    {
        $products = Concern::getProductByConcern($request->slug);
        $type = $products->title;
        $summary = $products->summary;
        $products = json_encode($products->products);
        return view('frontend.pages.product-grids', compact('products', 'type', 'summary'));

    }

    public function productConcerns(Request $request)
    {
        //dd($request->slug);
        $products = Concern::getProductByConcern($request->slug);
        $type = Concern::where('slug', $request->slug)->orderBy('title', 'ASC')->get();

        $recent_products = Product::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();
        // return $recent_products;
        return view('frontend.pages.product-type')->with('products', $products->products)->with('recent_products', $recent_products)->with('type', $type);
    }



    public function productCat(Request $request)
    {
        $cproducts = Category::getProductByCat($request->slug);
        // return $cproducts;
        $type = $cproducts->title;
        $summary = $cproducts->summary;
        $products = json_encode($cproducts->products_cat);
        $recent_products = Variant::where('status', 'active')->orderBy('id', 'DESC')->get();
        return view('frontend.pages.product-grids', compact('summary', 'type', 'products'));
    }

    public function AllCategory()
    {
        $type = Category::getCategory();
        //   return $type;
        $recent_products = Product::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();
        $title = 'Category';
        $href = "product-sub-categories/";
        if (request()->is('Dr Awish.loc/product-type')) {
            return view('frontend.pages.product-type')->with('type', $type->data)->with('recent_products', $recent_products)->with('title', $title)->with('href', $href);
        } else {
            return view('frontend.pages.product-type')->with('type', $type)->with('recent_products', $recent_products)->with('title', $title)->with('href', $href);
        }
    }

    public function AllSubCategory(Request $request)
    {
        //dd($request->slug);
        $type = Category::getAllSubCategory($request->slug);
        //  return $type;
        $recent_products = Product::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();
        $title = 'Category1';
        $href = "product-sub-cat/";
        if (request()->is('Dr Awish.loc/product-type')) {
            return view('frontend.pages.product-type')->with('type', $type->data)->with('recent_products', $recent_products)->with('title', $title)->with('href', $href);
        } else {
            return view('frontend.pages.product-type')->with('type', $type)->with('recent_products', $recent_products)->with('title', $title)->with('href', $href);
        }
    }

    public function AllConcern()
    {
        $type = Concern::getConcern();
        // return $type;
        $href = "product-sub-concerns/";
        $recent_products = Product::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();
        $title = 'Concern';
        if (request()->is('Dr Awish.loc/product-type')) {
            return view('frontend.pages.product-type')->with('type', $type->data)->with('recent_products', $recent_products)->with('title', $title)->with('href', $href);
        } else {
            return view('frontend.pages.product-type')->with('type', $type)->with('recent_products', $recent_products)->with('title', $title)->with('href', $href);
        }
    }
    public function AllSubConcern(Request $request)
    {
        $type = Concern::getAllSubConcern($request->slug);
        //   return $type;
        $href = "product-sub-concern/";
        $recent_products = Product::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();
        $title = 'Concern';
        if (request()->is('Dr Awish.loc/product-type')) {
            return view('frontend.pages.product-type')->with('type', $type->data)->with('recent_products', $recent_products)->with('title', $title)->with('href', $href);
        } else {
            return view('frontend.pages.product-type')->with('type', $type)->with('recent_products', $recent_products)->with('title', $title)->with('href', $href);
        }
    }
    public function AllType()
    {
        $type = ProductType::getType();
        // return $type;
        $href = "product-type/";
        $recent_products = Product::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();
        $title = 'Product-Type';
        if (request()->is('Dr Awish.loc/product-type')) {
            return view('frontend.pages.product-type')->with('type', $type->data)->with('recent_products', $recent_products)->with('title', $title)->with('href', $href);
        } else {
            return view('frontend.pages.product-type')->with('type', $type)->with('recent_products', $recent_products)->with('title', $title)->with('href', $href);
        }
    }

    public function AllSubType(Request $request)
    {
        $type = ProductType::getChildByParentID($request->slug);
        //   return $type;
        $href = "product-sub-type/";
        $recent_products = Product::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();
        $title = 'Product-sub-Type';
        if (request()->is('Dr Awish.loc/product-type')) {
            return view('frontend.pages.product-type')->with('type', $type->data)->with('recent_products', $recent_products)->with('title', $title)->with('href', $href);
        } else {
            return view('frontend.pages.product-type')->with('type', $type)->with('recent_products', $recent_products)->with('title', $title)->with('href', $href);
        }
    }
    public function AllBrand()
    {
        $type = Brand::getAllBrand();
        //   return $type;
        $href = "product-brand/";

        $recent_products = Product::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();
        $title = 'Brand';
        if (request()->is('Dr Awish.loc/product-type')) {
            return view('frontend.pages.product-type')->with('type', $type->data)->with('recent_products', $recent_products)->with('title', $title)->with('href', $href);
        } else {
            return view('frontend.pages.product-type')->with('type', $type)->with('recent_products', $recent_products)->with('title', $title)->with('href', $href);
        }
    }

    public function AllSubBrand(Request $request)
    {
        $type = Brand::getChildByParentID($request->slug);
        //   return $type;
        $href = "product-brand/";

        $recent_products = Product::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();
        $title = 'Brand';
        if (request()->is('Dr Awish.loc/product-type')) {
            return view('frontend.pages.product-type')->with('type', $type->data)->with('recent_products', $recent_products)->with('title', $title)->with('href', $href);
        } else {
            return view('frontend.pages.product-type')->with('type', $type)->with('recent_products', $recent_products)->with('title', $title)->with('href', $href);
        }
    }
    public function productSubCat(Request $request)
    {
        $products = Category::getProductBySubCat($request->sub_slug);
        $type = $products->title;
        $summary = $products->summary;
        $products = json_encode($products->sub_products);
        return view('frontend.pages.product-grids', compact('summary', 'type', 'products'));
    }

    public function productSubConcern(Request $request)
    {
        $products = Concern::getProductBySubConcern($request->sub_slug);
        $type = $products->title;
        $summary = $products->summary;
        $products = json_encode($products->sub_products);
        return view('frontend.pages.product-grids', compact('summary', 'type', 'products'));
    }

    public function blog()
    {
        $post = Post::query();

        if (!empty($_GET['category'])) {
            $slug = explode(',', $_GET['category']);
            // dd($slug);
            $cat_ids = PostCategory::select('id')->whereIn('slug', $slug)->pluck('id')->toArray();
            // return $cat_ids;
            $post->whereIn('post_cat_id', $cat_ids);
            // return $post;
        }
        if (!empty($_GET['tag'])) {
            $slug = explode(',', $_GET['tag']);
            // dd($slug);
            $tag_ids = PostTag::select('id')->whereIn('slug', $slug)->pluck('id')->toArray();
            // return $tag_ids;
            $post->where('post_tag_id', $tag_ids);
            // return $post;
        }

        if (!empty($_GET['show'])) {
            $post = $post->where('status', 'active')->orderBy('id', 'DESC')->paginate($_GET['show']);
        } else {
            $post = $post->where('status', 'active')->orderBy('id', 'DESC')->paginate(9);
        }
        // $post=Post::where('status','active')->paginate(8);
        $rcnt_post = Post::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();
        return view('frontend.pages.blog')->with('posts', $post)->with('recent_posts', $rcnt_post);
    }

    public function blogDetail($slug)
    {
        $post = Post::getPostBySlug($slug);
        $rcnt_post = Post::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();
        // return $post;
        return view('frontend.pages.blog-detail')->with('post', $post)->with('recent_posts', $rcnt_post);
    }

    public function blogSearch(Request $request)
    {
        // return $request->all();
        $rcnt_post = Post::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();
        $posts = Post::orwhere('title', 'like', '%' . $request->search . '%')
            ->orwhere('quote', 'like', '%' . $request->search . '%')
            ->orwhere('summary', 'like', '%' . $request->search . '%')
            ->orwhere('description', 'like', '%' . $request->search . '%')
            ->orwhere('slug', 'like', '%' . $request->search . '%')
            ->orderBy('id', 'DESC')
            ->paginate(8);
        return view('frontend.pages.blog')->with('posts', $posts)->with('recent_posts', $rcnt_post);
    }

    public function blogFilter(Request $request)
    {
        $data = $request->all();
        // return $data;
        $catURL = "";
        if (!empty($data['category'])) {
            foreach ($data['category'] as $category) {
                if (empty($catURL)) {
                    $catURL .= '&category=' . $category;
                } else {
                    $catURL .= ',' . $category;
                }
            }
        }

        $tagURL = "";
        if (!empty($data['tag'])) {
            foreach ($data['tag'] as $tag) {
                if (empty($tagURL)) {
                    $tagURL .= '&tag=' . $tag;
                } else {
                    $tagURL .= ',' . $tag;
                }
            }
        }
        // return $tagURL;
        // return $catURL;
        return redirect()->route('blog', $catURL . $tagURL);
    }

    public function blogByCategory(Request $request)
    {
        $post = PostCategory::getBlogByCategory($request->slug);
        $rcnt_post = Post::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();
        return view('frontend.pages.blog')->with('posts', $post->post)->with('recent_posts', $rcnt_post);
    }

    public function blogByTag(Request $request)
    {
        // dd($request->slug);
        $post = Post::getBlogByTag($request->slug);
        // return $post;
        $rcnt_post = Post::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();
        return view('frontend.pages.blog')->with('posts', $post)->with('recent_posts', $rcnt_post);
    }

    // Login
    public function login()
    {
        if (!Session::has('previous_url')) {
            session(['previous_url' => url()->previous()]);
        }
        $host = env('HOST');
        return view('frontend.pages.login', compact('host'));
    }


    public function logout()
    {
        // Session::forget('user');
        Auth::logout();
        session()->flash('success', 'Logout successfully');
        return redirect()->route('home');
    }

    public function register()
    {
        return view('frontend.pages.register');
    }
    public function registerSubmit(Request $request)
    {
        // return $request->all();
        $this->validate($request, [
            'name' => 'string|required|min:2',
            'email' => 'string|required|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);
        $data = $request->all();
        // dd($data);
        $check = $this->create($data);
        Session::put('user', $data['email']);
        if ($check) {
            session()->flash('success', 'Successfully registered');
            return view('frontend.pages.login');
        } else {
            session()->flash('error', 'Please try again!');
            return back();
        }
    }

    public function routineSubmit(Request $request)
    {

        $data = $request->all();
        //dd($data);
        $status = Userroutine::create($data);
        $product1 = Routine::where('age', $data['age'])->where('skin', $data['skin'])->where('pconcern_id', $data['pconcern_id'])->where('sconcern_id', $data['sconcern_id'])->where('pconcern_id', $data['pconcern_id'])->where('sensitive', $data['sensitive'])->where('pb', $data['pb'])->get();
        $product2 = '1,2,3';
        $product3 = explode(",", $product2);

        $product = Product::where('status', 'active')->whereIn('id', $product3)->get();
        if ($status) {
            return view('frontend.pages.product-grids')->with('products', json_encode($product));
        }
    }
    public function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'mobile' => $data['mobile'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'status' => 'active'
        ]);
    }
    // Reset password
    public function showResetForm()
    {
        return view('auth.passwords.old-reset');
    }

    public function subscribe(Request $request)
    {
        // Validate the email input
        $request->validate(['email' => 'required|email']);

        $email = $request->email;

        // Log the email for debugging purposes
        Log::info("Attempting to subscribe email: $email");
        return redirect()->route('home');
        // Check if the email is already subscribed
        // if (!Newsletter::isSubscribed($email)) {
        //     // Attempt to subscribe the email
        //     Newsletter::subscribePending($email);

        //     // Check if the last action succeeded
        //     if (Newsletter::lastActionSucceeded()) {
        //         Log::info("Successfully subscribed email: $email");

        //         session()->flash('success', 'Subscribed! Please check your email.');
        //         return redirect()->route('home');
        //     } else {
        //         // Log the error
        //         Log::error("Subscription failed for email: $email. Error: " . Newsletter::getLastError());

        //         return back()->with('error', 'Something went wrong! Please try again.');
        //     }
        // } else {
        //     Log::info("Email is already subscribed: $email");
        //     dd("Email is already subscribed: $email");
        //     session()->flash('error', 'Already Subscribed.');
        //     return back();
        // }
    }


    public function getAddress(Request $request)
    {
        return Shopping::where('id', $request->id)->get()->first();
    }
    public function removeAddress(Request $request)
    {
        return Shopping::where('id', $request->id)->delete();
    }


    // edit account details 
    public function editaccount(Request $request)
    {
        // Get the authenticated user
        $user = Auth::user();

        // Check if the user is authenticated
        if ($user) {
            // Validate the request
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate image
            ]);

            // Update the user's name and email
            $user->name = $request->name;
            $user->email = $request->email;

            // Handle the profile image upload
            if ($request->hasFile('profile_image')) {
                $image = $request->file('profile_image');

                // Generate a unique file name
                $fileName = time() . '_' . $image->getClientOriginalName();

                // Define the path to store the image in the 'public/profile_images' directory
                $publicPath = public_path('profile_images');

                // Create the directory if it doesn't exist
                if (!File::exists($publicPath)) {
                    File::makeDirectory($publicPath, 0755, true);
                }

                // Move the image to the public directory
                $image->move($publicPath, $fileName);

                // Store the path in the database
                $user->photo = 'profile_images/' . $fileName; // Assuming you have a profile_image field in your users table
            }

            // Save the changes
            $user->save();

            // Return a JSON response
            return response()->json(['success' => true]);
        }

        // Return an error response if the user is not authenticated
        return response()->json(['success' => false, 'message' => 'User not authenticated.'], 401);
    }





}
