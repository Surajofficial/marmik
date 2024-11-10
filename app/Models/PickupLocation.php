<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PickupLocation extends Model
{
    use HasFactory;
    protected $fillable = [
        'pickup_location_nickname',
        'shiper_name',
        'email',
        'phone',
        'address',
        'address_2',
        'city',
        'state',
        'country',
        'pin_code',
        'lat',
        'long',
        'address_type',
        'vendor_name',
        'gstin',
    ];
}
