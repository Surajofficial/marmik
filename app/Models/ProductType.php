<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    protected $fillable = ['title', 'slug', 'summary', 'photo', 'status', 'is_parent', 'parent_id', 'added_by'];

    public function parent_info()
    {
        return $this->hasOne('App\Models\ProductType', 'id', 'parent_id');
    }
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_product_type');
    }
    public static function getAllType()
    {
        return ProductType::where('is_parent', 1)->orderBy('id', 'DESC')->with('parent_info')->get();
    }
    public static function getType()
    {
        return Category::orderBy('id', 'DESC')->where('is_parent', 1)->paginate(10);
    }
    public static function shiftChild($cat_id)
    {
        return ProductType::whereIn('id', $cat_id)->update(['is_parent' => 1]);
    }
    public static function getChildByParentID($id)
    {
        return ProductType::where('parent_id', $id)->orderBy('id', 'ASC')->pluck('title', 'id');
    }

    public function child_cat()
    {
        return $this->hasMany('App\Models\ProductType', 'parent_id', 'id')->where('status', 'active');
    }
    public static function getAllParentWithChild()
    {
        return ProductType::with('child_cat')->where('is_parent', 1)->where('status', 'active')->orderBy('title', 'ASC')->get();
    }
    // public function products()
    // {
    //     return $this->hasMany('App\Models\Product', 'ptype_id', 'id')->where('status', 'active');
    // }
    public function sub_products()
    {
        return $this->hasMany('App\Models\Product', 'child_ptype_id', 'id')->where('status', 'active');
    }

    public static function getProductByType($slug)
    {
        return ProductType::with([
            'products' => function ($query) {
                $query->distinct('products.id') // Explicitly mention the table name to avoid ambiguity
                    ->select('products.id', 'products.photo', 'products.title', 'products.slug');
            },
            'products.maxPriceVariant:id,product_id,discount,price,stock'
        ])->where('product_types.slug', $slug)
            ->first(['title', 'id', 'summary']);
    }


}
