<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stocks extends Model
{
    use HasFactory;
    protected $fillable = [
        'center_id',
        'variant_id',
        'stock',
        'mfg',
        'expiry',
        'batch_no',
        'price',
        'discount'
    ];

    public function variant()
    {
        return $this->belongsTo(Variant::class);
    }
    public function product()
    {
        return $this->hasOneThrough(
            Product::class,
            Variant::class,
            'id',
            'id',
            'variant_id',
            'product_id'
        );
    }
    public function strep()
    {
        return $this->hasOneThrough(
            Strep::class,
            Variant::class,
            'id',
            'id',
            'variant_id',
            'size'
        );
    }

    public function center()
    {
        return $this->belongsTo(Center::class, 'center_id', 'id');
    }
}
