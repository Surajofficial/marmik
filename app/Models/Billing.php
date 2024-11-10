<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{
    use HasFactory;
 protected $fillable=['gtype','bdate','pstatus','product','qty','billingName','billingAddress','alltax','subtotal','pmethod'];

}
