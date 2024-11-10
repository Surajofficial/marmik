<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Wishlist;

class WishlistController extends Controller
{
    protected $product = null;
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function toggle(Request $request)
    {
       
        $product = Product::find($request->product_id);

        if ($product) {
            $wishlisted = $product->toggleWishlist($request->product_variants_id);
            return response()->json(['wishlisted' => $wishlisted]);
        }

        return response()->json(['wishlisted' => false], 404);
    }
    public function removeFromWishlist(Request $request)
    {
        $userId = auth()->id();
        $productId = $request->input('product_id');
        $product_variants_id = $request->input('product_variants_id');

        // Find the wishlist item for the authenticated user
        $wishlistItem = Wishlist::where('user_id', $userId)
            ->where('product_id', $productId)
            ->where('product_variants_id', $product_variants_id)
            ->first();

        if ($wishlistItem) {
            $wishlistItem->delete(); // Remove the item from the wishlist
            $wishlistCount = Wishlist::where('user_id', $userId)->count();

            return response()->json(['success' => true, 'wishlistCount' => $wishlistCount]);
        } else {
            return response()->json(['success' => false]);
        }
    }
}
