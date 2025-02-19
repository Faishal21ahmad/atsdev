<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'category_name',
        'description',
    ];
    
    protected $dates = ['deleted_at'];

    // Relasi ke MasterAsset
    public function masterAssets()
    {
        return $this->hasMany(MasterAsset::class);
    }

    public function scopeActive($query)
    {
        return $query->whereNull('deleted_at');
    }
}
