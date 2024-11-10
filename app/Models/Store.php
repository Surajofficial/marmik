<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $fillable = [
        'title',
        'address',
        'locationurl',  // Ensure this is included
        'status',
    ];
}
