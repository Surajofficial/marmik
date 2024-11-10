<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Concern extends Model
{
    protected $fillable = ['title', 'slug', 'summary', 'photo', 'status', 'is_parent', 'parent_id', 'added_by'];

    public function parent_info()
    {
        return $this->hasOne(Concern::class, 'id', 'parent_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'concern_product');
    }
    public static function getAllConcern()
    {
        return Concern::orderBy('id', 'DESC')->with('parent_info')->get();
    }
    public static function getConcern()
    {
        return Concern::orderBy('id', 'DESC')->where('is_parent', 1)->paginate(10);
    }
    public static function shiftChild($cat_id)
    {
        return Concern::whereIn('id', $cat_id)->update(['is_parent' => 1]);
    }
    public static function getChildByParentID($id)
    {
        return Concern::where('parent_id', $id)->orderBy('id', 'ASC')->pluck('title', 'id');
    }
    public static function getAllSubConcern($slug)
    {
        $id = Concern::where('slug', $slug)->get();
        //dd($id[0]->id);
        return Concern::where('parent_id', $id[0]->id)->orderBy('id', 'DESC')->with('parent_info')->paginate(10);
    }

    public function child_cat()
    {
        return $this->hasMany('App\Models\Concern', 'parent_id', 'id')->where('status', 'active');
    }
    public static function getAllParentWithChild()
    {
        return Concern::with('child_cat')->where('is_parent', 1)->where('status', 'active')->orderBy('title', 'ASC')->get();
    }
    // public function products()
    // {
    //     return $this->hasMany('App\Models\Product', 'concern_id', 'id')->where('status', 'active');
    // }
    public function sub_products()
    {
        return $this->hasMany('App\Models\Product', 'child_concern_id', 'id')->where('status', 'active');
    }
    public static function getProductByConcern($slug)
    {
        return Concern::where('concerns.slug', $slug)->with([
            'products' => function ($query) {
                $query->distinct('products.id') // Explicitly mention the table name to avoid ambiguity
                    ->select('products.id', 'products.photo', 'products.title', 'products.slug');
            },
            'products.maxPriceVariant:id,product_id,discount,price,stock'
        ])->first(['title', 'id', 'summary']);
    }
    public static function getProductBySubConcern($slug)
    {
        // return $slug;
        return Concern::with('sub_products')->where('slug', $slug)->first();
    }
    public static function countActiveCategory()
    {
        $data = Concern::where('status', 'active')->count();
        if ($data) {
            return $data;
        }
        return 0;
    }
}
