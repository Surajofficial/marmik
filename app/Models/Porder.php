<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Porder extends Model
{
    use HasFactory;
    protected $fillable=['pid','onumber','quantity','price'];

}
