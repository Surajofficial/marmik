<?php

namespace App\Models;


use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'photo',
        'mobile',
        'city',
        'otp_code',
        'otp_expires_at',
        'status',
    ];


    protected $hidden = [
        'otp_code',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'otp_expires_at' => 'datetime',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }


    public function couponsnew()
    {
        return $this->belongsToMany(Couponnew::class, 'coupon_user', 'user_id', 'coupon_id')
            ->withPivot('used_at')
            ->withTimestamps();
    }


    /**
     * Retrieve all applicable coupons (assigned and global) that haven't been used.
     *
     * @return \Illuminate\Support\Collection
     */
    public function applicableCoupons()
    {
        // Assigned coupons that haven't been used
        $assignedCoupons = $this->couponsnew()->wherePivot('used_at', null);

        // Global coupons that haven't been used and are not expired
        $globalCoupons = Couponnew::whereDoesntHave('users')
            ->where(function ($query) {
                $query->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            });

        return $assignedCoupons->get()->merge($globalCoupons->get());
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

}
