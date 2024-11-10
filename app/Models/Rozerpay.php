<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rozerpay extends Model
{
    use HasFactory;
    protected $fillable = ['status', 'rozorpay_id', 'amount'];
}
