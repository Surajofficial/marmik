<?php

namespace App\Models;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class Strep extends Model
{
    protected $fillable = ['title', 'slug', 'status'];
}
