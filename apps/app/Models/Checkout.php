<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Database\Eloquent\Builder;

class Checkout extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'codecheckout',
        'user_id',
        'vendor_id',
        'reason',
        'total',
        'description',
    ];
    protected $dates = ['deleted_at'];

    // Relasi ke CheckoutItemDetail
    public function checkoutItemDetail()
    {
        return $this->hasMany(CheckoutItemDetail::class);
    }
    // Relasi ke Vendor
    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    

    // Scope untuk mendapatkan Checkout yang aktif
    public function scopeActive($query)
    {
        return $query->whereNull('deleted_at');
    }
    // Scope untuk mendapatkan Checkout dengan jumlah ItemAsset terkait
    public static function getAllWithItemAssetCount(): Builder
    {
        return self::query()
            ->select([
                'checkouts.id',
                'checkouts.vendor_id',
                'checkouts.codecheckout',
                'checkouts.created_at',
                'vendors.vendor_name',
            ])
            ->leftJoin('vendors','vendors.id', '=', 'checkouts.vendor_id')
            ->selectRaw('(
                SELECT COUNT(*) 
                FROM checkout_item_details 
                WHERE checkout_id = checkouts.id
            ) as total_item_asset');
    }
}
