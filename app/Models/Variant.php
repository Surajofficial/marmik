<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
    use HasFactory;
    protected $table = "product_variants";
    protected $fillable = [
        'product_id',
        'size',
        'sku',
        'status',
        'width',
        'height',
        'length',
        'weight',
        'rules',
        'is_featured',
        'is_best_seller',
        'best_seller_no',
        'fearured_no',
        'price',
        'special_price',
        'discount',
        'stock'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function strep()
    {
        return $this->belongsTo(Strep::class, 'size');
    }
    public function batches()
    {
        return $this->hasMany(Stocks::class);
    }
    public static function getAllVariant()
    {
        return Variant::with('product')->with('strep')->orderBy('id', 'desc')->get();
    }

    public function isInWishlist()
    {
        if (Auth::check()) {
            return Wishlist::where('user_id', Auth::id())
                ->where('product_id', $this->product_id) // Assuming 'product_id' refers to variant ID
                ->exists();
        }

        return false; // Not in wishlist if the user is not authenticated
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class, 'product_variants_id');
    }

}
