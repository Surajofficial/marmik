<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Couponnew extends Model
{
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'code',
        'description',
        'discount_type',
        'discount_value',
        'min_order',
        'max_discount',
        'expires_at',
        'product_id',
    ];
    protected $table = "coupons_new";

    /**
     * The users that are assigned to this coupon.
     */

    public function users()
    {
        return $this->belongsToMany(User::class, 'coupon_user', 'coupon_id', 'user_id')
            ->withPivot('used_at')
            ->withTimestamps();
    }


    /**
     * Determine if the coupon is global (not assigned to any specific users).
     */
    public function isGlobal()
    {
        return $this->users()->count() === 0;
    }
}
