<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable=['title','slug','description','photo','quote','added_by','status'];

  
    public function author_info(){
        return $this->hasOne('App\Models\User','id','added_by');
    }
    public static function getAllTestimonial(){
        return Testimonial::with(['author_info'])->orderBy('id','DESC')->paginate(10);
    }
    // public function get_comments(){
    //     return $this->hasMany('App\Models\PostComment','post_id','id');
    // }
    public static function getTestimonialBySlug($slug){
        return Testimonial::with(['author_info'])->where('slug',$slug)->where('status','active')->first();
    }



    // public static function getProductByCat($slug){
    //     // dd($slug);
    //     return Category::with('products')->where('slug',$slug)->first();
    //     // return Product::where('cat_id',$id)->where('child_cat_id',null)->paginate(10);
    // }

    // public static function getBlogByCategory($id){
    //     return Post::where('post_cat_id',$id)->paginate(8);
    // }

    public static function countActiveTestimonial(){
        $data=Testimonial::where('status','active')->count();
        if($data){
            return $data;
        }
        return 0;
    }
}
