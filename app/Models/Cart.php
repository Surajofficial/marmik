<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = ['user_id', 'product_id', 'order_id', 'quantity', 'amount', 'price', 'status', 'orignalAmount', 'cgst', 'sgst', 'tax', 'discount'];
    public function product()
    {
        return $this->belongsTo(Variant::class, 'product_id');
    }
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
