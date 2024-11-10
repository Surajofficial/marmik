<?php

namespace App\Models;

use App\Models\Admin\OfflineInvoice;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OfflineCart extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'invoice_id',
        'stock_id',
        'quantity',
        'price',
        'discount',
        'cgst',
        'sgst',
        'gst',
    ];

    public function invoice()
    {
        return $this->belongsTo(OfflineInvoice::class, 'invoice_id', 'id');
    }

    public function stock()
    {
        return $this->belongsTo(Stocks::class, 'stock_id', 'id');
    }
}
