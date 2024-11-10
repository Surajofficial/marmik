<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Userroutine extends Model
{
    use HasFactory;
    protected $fillable=['name','email','age','skin','pconcern_id','sconcern_id','sensitive','pb'];

}
