<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Newctas extends Model
{
    protected $fillable=['title','description','url','image','sdate','enddate'];
    public static function getAllCta(){
        return Newctas::orderBy('id','DESC')->paginate(10);
    }


}
