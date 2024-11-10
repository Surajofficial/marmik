<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['title', 'slug', 'summary', 'photo', 'status', 'is_parent', 'parent_id', 'added_by'];

    public function parent_info()
    {
        return $this->hasOne(Category::class, 'id', 'parent_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'category_product');
    }
    public static function getAllCategory()
    {
        return Category::orderBy('id', 'DESC')->with('parent_info')->paginate(10);
    }

    public static function getCategory()
    {
        return Category::orderBy('id', 'DESC')->where('is_parent', 1)->paginate(10);
    }
    public static function getAllSubCategory($slug)
    {
        $id = Category::where('slug', $slug)->get();
        return Category::where('parent_id', $id[0]->id)->orderBy('id', 'DESC')->with('parent_info')->paginate(10);
    }

    public static function shiftChild($cat_id)
    {
        return Category::whereIn('id', $cat_id)->update(['is_parent' => 1]);
    }
    public static function getChildByParentID($id)
    {
        return Category::where('parent_id', $id)->orderBy('id', 'ASC')->pluck('title', 'id');
    }

    public function child_cat()
    {
        return $this->hasMany('App\Models\Category', 'parent_id', 'id')->where('status', 'active');
    }
    public static function getAllParentWithChild()
    {
        return Category::with('child_cat')->where('is_parent', 1)->where('status', 'active')->orderBy('title', 'ASC')->get();
    }
    public function products_cat()
    {
        return $this->hasMany(Product::class, 'cat_id', 'id');
    }
    public function sub_products()
    {
        return $this->hasMany(Product::class, 'child_cat_id', 'id');
    }
    public static function getProductByCat($slug)
    {
        // dd($slug);
        return Category::with(['products_cat.maxPriceVariant:id,product_id,discount,price,stock', 'products_cat:id,cat_id,photo,title,slug'])
            ->where('slug', $slug)
            ->first(['title', 'id', 'summary', 'slug']);
        // return Product::where('cat_id',$id)->where('child_cat_id',null)->paginate(10);
    }
    public static function getProductBySubCat($slug)
    {
        return Category::with(['sub_products.maxPriceVariant:id,product_id,discount,price,stock', 'sub_products:id,child_cat_id,photo,title,slug'])
            ->where('slug', $slug)
            ->first(['title', 'id', 'summary', 'slug']);
    }
    public static function countActiveCategory()
    {
        $data = Category::where('status', 'active')->count();
        if ($data) {
            return $data;
        }
        return 0;
    }
}
