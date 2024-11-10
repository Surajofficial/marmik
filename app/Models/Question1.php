<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question1 extends Model
{
    protected $fillable=['title','question','answer','status'];


    public static function getAllFaq(){
        return Question::with(['status'])->orderBy('id','DESC')->paginate(10);
    }


    public static function countActiveFaq(){
        $data=Question::where('status','active')->count();
        if($data){
            return $data;
        }
        return 0;
    }
}
