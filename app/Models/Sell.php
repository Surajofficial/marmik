<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sell extends Model
{
    use HasFactory;

    protected $table = 'posts';

    protected $fillable = [
        'product_id',
        'price',
        'quantity',
        'mode',
        'status',
        'customer_name',
        'customer_mobile',
        'customer_address',
        'customer_email',
        'customer_gst'
    ];
}
