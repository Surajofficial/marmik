<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockInvoice extends Model
{
    use HasFactory,SoftDeletes;

    // Specify the table name if it differs from the plural form of the model name
    protected $table = 'stock_invoices';

    // Specify the fields that are mass assignable
    protected $fillable = [
        'invoice_no',
        'invoice_type',
        'invoice_date',
        'payment_method',
        'sub_total',
        'total_quantity',
        'total_cgst',
        'total_sgst',
        'total_amount',
        'amount_in_words',
        'products',
        'customer_name',
        'customer_email',
        'customer_phone',
        'customer_address',
    ];

    // If you store product details as JSON, you can cast it to an array
    protected $casts = [
        'products' => 'array',
    ];
}
