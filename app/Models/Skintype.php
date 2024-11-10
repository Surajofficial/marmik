<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skintype extends Model
{
    use HasFactory;
    protected $fillable=['title','photo'];
    public static function getAllSkin(){
        return  Skintype::orderBy('id','DESC')->get();
    }
    public static function getConcern(){
        return  Skintype::orderBy('id','DESC')->get();
    }

}
