<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MasterAsset extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'category_id',
        'asset_name',
        'slug',
        'interval_maintence',
        'min_stock',
        'current_stock',
        'image_name',
        'description',
    ];

    protected $dates = ['deleted_at'];


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($asset) {
            $slug = Str::slug($asset->asset_name);
            $count = MasterAsset::where('slug', 'LIKE', "$slug%")->count();
            $asset->slug = $count ? "$slug-" . ($count + 1) : $slug;
        });
    }

    // Relasi ke Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi ke ItemAsset
    public function itemAssets()
    {
        return $this->hasMany(ItemAsset::class);
    }

    // Relasi ke CheckinMasterDetail
    public function checkinMasterDetails()
    {
        return $this->hasMany(CheckinMasterDetail::class);
    }
    
    // Relasi ke Maintenance
    public function maintenances()
    {
        return $this->hasMany(Maintenance::class);
    }

    /**
     * Query scope untuk mengambil aset yang belum dihapus (belum soft delete)
     */
    public function scopeActive($query)
    {
        return $query->whereNull('deleted_at');
    }

    /**
     * Cek apakah stok aset ini low (kurang dari min_stock)
     */
    public function isStockLow()
    {
        return $this->current_stock < $this->min_stock;
    }

    /**
     * Ambil jumlah master assets yang stoknya rendah
     */
    public static function countLowStockAssets()
    {
        return self::whereColumn('current_stock', '<', 'min_stock')->count();
    }

    /**
     * Ambil daftar master assets yang stoknya rendah
     */
    public static function getLowStockAssets()
    {
        return self::whereColumn('current_stock', '<', 'min_stock')->get();
    }
}
