<?php

namespace App\Models;

use App\Models\Checkout;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ItemAsset extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'master_asset_id',
        'checkin_master_detail_id',
        'location_id',
        'department_id',
        'vendor_id',
        'check_out_id',
        'code_assets',
        'description',
        'condition',
        'status',
    ];

    protected $dates = ['deleted_at'];
    
    // Relasi ke MasterAsset
    public function masterAsset()
    {
        return $this->belongsTo(MasterAsset::class);
    }

    // Relasi ke CheckinMasterDetail
    public function checkinMasterDetail()
    {
        return $this->belongsTo(CheckinMasterDetail::class);
    }

    // Relasi ke Location
    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    // Relasi ke Department
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    // Relasi ke Vendor
    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    // Relasi ke Checkout
    public function checkout()
    {
        return $this->belongsTo(Checkout::class);
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


    public static function countNotCheckedOut()
    {
        return self::where('status', '!=', 'checked_out')->count();
    }

     /**
     * Ambil data item asset berdasarkan master_asset_id dan belum dihapus.
     */
    public static function getByMasterAssetId($masterAssetId)
    {
        return self::where('master_asset_id', $masterAssetId)
            ->whereNull('deleted_at')
            ->where('status', '!=', 'checked_out')
            ->get();
    }

     /**
     * Ambil data item asset berdasarkan code dan belum dihapus.
     */
    public static function getBycodeItemAssets($codeAsset)
    {
        return self::where('code_assets', $codeAsset)
            ->whereNull('deleted_at')
            ->get();
    }

    public static function getItemAssetsWithMasterAsset()
    {
        return self::with('masterAsset')
            ->select('item_assets.code_assets', 'master_assets.asset_name')
            ->join('master_assets', 'item_assets.master_asset_id', '=', 'master_assets.id')
            ->get();
    }

}
