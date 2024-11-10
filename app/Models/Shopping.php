<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shopping extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'country',
        'address1',
        'address2',
        'post_code',
        'atype',
        'user_id',
        'alter_nate_phone',
        'state',
        'city'
    ];
    public static function getAllShopping()
    {
        return Shopping::orderBy('id', 'DESC');
    }
}
