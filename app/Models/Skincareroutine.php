<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skincareroutine extends Model
{
    use HasFactory;
    // The table associated with the model
    protected $table = 'skin_care_routine';

    // Mass assignable attributes
    protected $fillable = [
        'name',
        'gender',
        'age',
        'mobile',
        'email',
    ];
}
