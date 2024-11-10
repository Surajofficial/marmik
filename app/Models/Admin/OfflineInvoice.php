<?php

namespace App\Models\Admin;

use App\Http\Middleware\User;
use App\Models\OfflineCart;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OfflineInvoice extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'invoice_no',       // Invoice Number
        'date',              // Invoice Date
        'user_id',           // User ID (Foreign key)
        'payment_method',    // Payment Method
        'total_amount',      // Total amount for the invoice
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function carts()
    {
        return $this->hasMany(OfflineCart::class, 'invoice_id');
    }
}
