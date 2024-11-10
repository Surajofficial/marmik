<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShipRocket extends Model
{
    use HasFactory;
    public function shippingAddress()
    {
        return $this->belongsTo(Shopping::class, 'shipping_address');
    }

    /**
     * Get the shopping record associated with the ship rocket.
     */
    public function billingAddress()
    {
        return $this->belongsTo(Shopping::class, 'billing_address');
    }
}
