<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class Checkin extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'codecheckin',
        'description',
        'total',
    ];

    protected $dates = ['deleted_at'];

    // Relasi ke CheckinMasterDetail
    public function checkinMasterDetails()
    {
        return $this->hasMany(CheckinMasterDetail::class);
    }

    public function scopeActive($query)
    {
        return $query->whereNull('deleted_at');
    }

    public static function getAllWithAssetTotals(): Builder
    {
        return self::query()
            ->select([
                'checkins.id',
                'checkins.codecheckin',
                'checkins.total',
                'checkins.created_at',
            ])
            ->selectRaw('(
                SELECT COUNT(*) 
                FROM checkin_master_details 
                WHERE check_in_id = checkins.id
            ) as total_master_asset')
            ->selectRaw('(
                SELECT COALESCE(SUM(quantity), 0)
                FROM checkin_master_details 
                WHERE check_in_id = checkins.id
            ) as total_item_asset');
    }
}
