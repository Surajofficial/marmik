<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable=['title','question','answer','status'];


    public static function getAllQuestion(){
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
