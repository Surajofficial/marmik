<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockProductReturn extends Model
{
    use HasFactory;

    protected $table = 'stock_product_returns';
    protected $fillable = [
        'invoice_id',
        'invoice_type',
        'return_reason',
        'return_date',
        'customer_phone',
        'customer_name',
        'customer_address',
        'place_of_supply',
        'products', // JSON field
        'sub_totals',
        'total_cgst',
        'total_sgst',
        'total_amount',
    ];

    // Cast products field as JSON
    protected $casts = [
        'products' => 'array',
    ];

}
