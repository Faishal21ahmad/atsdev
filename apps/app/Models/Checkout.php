<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Database\Eloquent\Builder;

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

    public static function getAllWithItemAssetCount(): Builder
    {
        return self::query()
            ->select([
                'checkouts.id',
                'checkouts.vendor_id',
                'checkouts.codecheckout',
                'checkouts.created_at'
            ])
            ->selectRaw('(
                SELECT COUNT(*) 
                FROM item_assets 
                WHERE check_out_id = checkouts.id
            ) as total_item_asset');
    }
}
