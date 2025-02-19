<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Checkout extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'vendor_id',
        'codecheckout',
        'description',
    ];
    protected $dates = ['deleted_at'];

    // Relasi ke Vendor
    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    // Relasi ke ItemAsset
    public function itemAssets()
    {
        return $this->hasMany(ItemAsset::class);
    }
    public function scopeActive($query)
    {
        return $query->whereNull('deleted_at');
    }
}
