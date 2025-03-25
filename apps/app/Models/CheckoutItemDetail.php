<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CheckoutItemDetail extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'checkout_id',
        'item_asset_id',
        'unit_price',
    ];
    protected $dates = ['deleted_at'];

    public function itemAsset()
    {
        return $this->belongsTo(ItemAsset::class);
    }

    public function checkouts()
    {
        return $this->belongsTo(Checkout::class);
    }

    // Scope untuk mendapatkan Checkout yang aktif
    public function scopeActive($query)
    {
        return $query->whereNull('deleted_at');
    }
}
