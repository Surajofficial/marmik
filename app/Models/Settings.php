<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class Settings extends Model
{
    protected $fillable = [
        'short_des',
        'description',
        'photo',
        'address',
        'phone',
        'mobile',
        'email',
        'logo',
        'boffer',
        'cartcolor',
        'categorytext',
        'concerntext',
        'brandtext',
        'seo',
        'analytics',
        'facebook',
        'instagram',
        'youtube',
        'name',
        'gst',
        'about_image',
        'delevery_fee_after',
        'tracking_link',
    ];
    public function scopeSelectExcept($query, $excludedColumns = [])
    {
        $table = $this->getTable();
        $columns = Schema::getColumnListing($table);
        $columnsToSelect = array_diff($columns, $excludedColumns);

        return $query->select($columnsToSelect);
    }
}
