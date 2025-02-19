<?php

namespace App\Models;

use App\Models\ItemAsset;
use App\Models\Maintenance;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Location extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'location_name',
        'description',
    ];

    protected $dates = ['deleted_at'];

    // Relasi ke ItemAsset
    public function itemAssets()
    {
        return $this->hasMany(ItemAsset::class);
    }
    
    // Relasi ke Maintenance
    public function maintenances()
    {
        return $this->hasMany(Maintenance::class);
    }

    public function scopeActive($query)
    {
        return $query->whereNull('deleted_at');
    }

}
