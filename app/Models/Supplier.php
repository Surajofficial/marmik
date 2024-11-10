<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
    protected $fillable = [
        'company','name','email','phone',
        'address','city','state','pin','bname','bnumber','bcode',
        'pno','gst','opening','contactp','contactn','odetail'
    ];
}
