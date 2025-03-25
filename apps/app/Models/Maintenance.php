<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Maintenance extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'code_maintenance',
        'item_asset_id',
        'vendor_id',
        'user_id_report',
        'user_id_resolve',
        'date_mainten',
        'report_type',
        'problem_detail',
        'repaire_detail',
        'cost',
        'status_mainten',
    ];

    // Relasi ke ItemAsset
    public function itemAsset()
    {
        return $this->belongsTo(ItemAsset::class);
    }

    // Relasi ke Vendor
    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function reportedBy()
    {
        return $this->belongsTo(User::class, 'user_id_report');
    }

    // Relasi ke User yang menyelesaikan (user_id_resolve)
    public function resolvedBy()
    {
        return $this->belongsTo(User::class, 'user_id_resolve');
    }
    
    // Relasi ke Filemainten
    public function fileMainten()
    {
        return $this->hasMany(FileMainten::class);
    }

    /**
     * Ambil semua data Maintenance Schedule yang belum dihapus (soft delete)
     * dan status_mainten-nya "reported"
     */
    public static function getReportedMaintenances()
    {
        return self::whereIn('status_mainten', ['Proses','Reported'])->whereNull('deleted_at')->orderBy('created_at', 'desc')->get();
    }
    public static function getByIditemAsset($id)
    {
        return self::where('item_asset_id', $id)
            ->whereNull('deleted_at')
            ->get();
    }

    public static function getByCodeMainten($codeMainten)
    {
        return self::where('code_maintenance', $codeMainten)
            ->whereNull('deleted_at')
            ->get();
    }

    public function scopeActive($query)
    {
        return $query->whereNull('deleted_at');
    }

    public static function getMaintenReported()
    {
        return self::where('status_mainten', 'Reported')
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'desc')
            ->get();
    }
    public static function getMaintenProses()
    {
        return self::where('status_mainten', 'Proses')
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'desc')
            ->get();
    }
    public static function getMaintenFinish()
    {
        return self::where('status_mainten', 'Finish')
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'desc')
            ->get();
    }
    public static function getReportedAndProgresMaintenances(){
        return self::where('status_mainten', 'Reported')
            ->orWhere('status_mainten', 'Proses')
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'desc')
            ->get();
    }

}
