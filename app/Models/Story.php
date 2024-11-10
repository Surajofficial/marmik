<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    protected $fillable=['title','description','photo'];
  

    public static function getAllStory(){
        return Story::orderBy('id','DESC')->paginate(10);
    }


}
