<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CheckinMasterDetail extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'check_in_id',
        'master_asset_id',
        'quantity',
        'unit_price',
        'sub_total',
    ];
    protected $dates = ['deleted_at'];

    // Relasi ke Checkin
    public function checkin()
    {
        return $this->belongsTo(Checkin::class);
    }

    // Relasi ke MasterAsset
    public function masterAsset()
    {
        return $this->belongsTo(MasterAsset::class);
    }

    public function scopeActive($query)
    {
        return $query->whereNull('deleted_at');
    }
}
