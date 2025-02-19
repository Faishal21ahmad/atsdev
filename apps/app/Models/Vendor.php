<?php

namespace App\Models;

use App\Models\Checkout;
use App\Models\ItemAsset;
use App\Models\Maintenance;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vendor extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'vendor_name',
        'contact',
        'address',
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

    // Relasi ke Checkout
    public function checkouts()
    {
        return $this->hasMany(Checkout::class);
    }
    // Pemanggilan data vendor yang aktif
    public function scopeActive($query)
    {
        return $query->whereNull('deleted_at');
    }
    
}
