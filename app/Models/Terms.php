<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Terms extends Model
{
    protected $fillable=['title','description','status'];
  

    public static function getAllTerms(){
     //   print_r(Terms);
        return Terms::orderBy('id','DESC')->paginate(10);
    }


    public static function countActiveTerms(){
        $data=Terms::where('status','active')->count();
        if($data){
            return $data;
        }
        return 0;
    }
}
