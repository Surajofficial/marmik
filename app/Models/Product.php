<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Model;
use App\Models\Cart;
use App\Models\Concern;
use DateTime;


class Product extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'summary',
        'description',
        'photo',
        'video',
        'brand_id',
        'cat_id',
        'child_cat_id',
        'concern_id',
        'child_concern_id',
        'ptype_id',
        'child_ptype_id',
        'routine_concern',
        'presc',
        'combo',
        'pts',
        'psr',
        'hsn_no',
        'cgst',
        'sgst',
        'tax',
        'how_to_use',
        'evidence',
        'is_visible_to_users'
    ];

    public function variants()
    {
        return $this->hasMany(Variant::class);
    }

    public static function getAllProduct()
    {
        $query = Product::with(['cat_info', 'sub_cat_info', 'concern_info', 'sub_concern_info'])
            ->orderBy('id', 'desc');

        if (Auth::check() && Auth::guard('admin')->user()->name === 'Admin') {
            return $query->get();
        }
        return $query->where('is_visible_to_users', true)->get();

    }

    public function maxPriceVariant()
    {
        return $this->hasOne(Variant::class)->where('status','active')->orderBy('price', 'ASC');
    }
    // Many-to-many relationship with ProductType
    // public function productTypes()
    // {
    //     return $this->belongsToMany(ProductType::class, 'product_product_type');
    // }
    public function productTypes()
    {
        return $this->belongsToMany(ProductType::class, 'product_product_type');
    }

    public function ptypes()
    {
        return $this->belongsToMany(ProductType::class);
    }
    // Many-to-many relationship with Category
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_product');
    }
    // Many-to-many relationship with Concern
    public function concerns()
    {
        return $this->belongsToMany(Concern::class, 'concern_product');
    }

    public function cat_info()
    {
        return $this->hasOne(Category::class, 'id', 'cat_id');
    }
    public function sub_cat_info()
    {
        return $this->hasOne(Category::class, 'id', 'child_cat_id');
    }

    public function concern_info()
    {
        return $this->hasOne(Concern::class, 'id', 'concern_id');
    }
    public function sub_concern_info()
    {
        return $this->hasOne(Concern::class, 'id', 'child_concern_id');
    }
    public function carts()
    {
        return $this->hasMany(Cart::class)->whereNotNull('order_id');
    }

    // public function wishlists()
    // {
    //     return $this->hasMany(Wishlist::class)->whereNotNull('cart_id');
    // }

    public function brand()
    {
        return $this->hasOne(Brand::class, 'id', 'brand_id');
    }
    public function batches()
    {
        return $this->hasManyThrough(Stocks::class, Variant::class, 'product_id', 'variant_id', 'id', 'id');
    }

    // public static function getAllProduct()
    // {
    //     return Product::with(['cat_info', 'sub_cat_info', 'concern_info', 'sub_concern_info'])->orderBy('id', 'desc')->get();
    // }

    public function rel_prods()
    {
        return $this->hasMany(Product::class, 'cat_id', 'cat_id')->orderBy('id', 'DESC')->limit(8);
    }
    public function getReview()
    {
        return $this->hasMany(ProductReview::class, 'product_id', 'id')->with('user_info')->where('status', 'active')->orderBy('id', 'DESC');
    }
    public static function getProductBySlug($slug)
    {
        return Product::with(['cat_info', 'rel_prods', 'getReview', 'variants'])->whereHas('variants', function ($query) {
            $query->where('status', 'active');
        })->where('slug', $slug)->first();
    }
    public static function countActiveProduct()
    {
        $data = Variant::where('status', 'active')->count();
        if ($data) {
            return $data;
        }
        return 0;
    }

    public static function countExpireProduct()
    {
        // Get all products with active variants
        $products = Product::whereHas('variants', function ($query) {
            $query->where('status', 'active');
        })->get();
        $count = 0;
        foreach ($products as $product) {
            // Iterate through each product's variants
            foreach ($product->variants as $variant) {
                // Check if the variant is active
                if ($variant->status === 'active') {
                    // Iterate through each variant's batches
                    foreach ($variant->batches as $batch) {
                        // Compare expiry date with the current date
                        $expiryDate = DateTime::createFromFormat('d/m/y', $batch->expiry);
                        if ($expiryDate < new DateTime()) {
                            $count++;
                        }
                    }
                }
            }
        }
        return $count;
    }

    public static function countStockProduct()
    {
        // Count the number of active products where stock is less than or equal to 0
        $count = Variant::where('status', 'active')
            ->where('stock', '<=', 0)
            ->count();
        return $count;
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }
    
    

    public function isWishlisted()
    {
        return $this->wishlists()->where('user_id', auth()->id())->exists();
    }

    public function toggleWishlist($productVariantsId = null)
    {
        $wishlist = Wishlist::where('user_id', auth()->id())
            ->where('product_id', $this->id)
            ->where('product_variants_id', $productVariantsId)
            ->first();

        if ($wishlist) {
            $wishlist->delete(); // If already in wishlist, remove it
            return false;
        } else {
            Wishlist::create([
                'user_id' => auth()->id(),
                'product_id' => $this->id,
                'product_variants_id' => $productVariantsId,
            ]);
            return true;
        }
    }

}
