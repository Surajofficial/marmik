<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Center extends Model
{
    use HasFactory;


    protected $fillable = ['center_name'];

    public function admins()
    {
        return $this->hasMany(Admin::class, 'center_id', 'id');
    }

    public function stocks()
    {
        return $this->hasMany(Stocks::class, 'center_id', 'id');
    }
}
