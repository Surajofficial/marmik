<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShipRocketUser extends Model
{
    use HasFactory;
    protected $fillable = [
        'email',
        'password',
        'token',
        'token_at'
    ];
}
