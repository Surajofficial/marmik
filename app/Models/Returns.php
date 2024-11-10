<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Returns extends Model
{
    protected $fillable=['title','description','photo','status'];
  
    public function author_info(){
        return $this->hasOne('App\Models\User','id','added_by');
    }
    public static function getAllReturns(){
        return Returns::orderBy('id','DESC')->paginate(10);
    }


    public static function countActiveReturns(){
        $data=Returns::where('status','active')->count();
        if($data){
            return $data;
        }
        return 0;
    }
}
