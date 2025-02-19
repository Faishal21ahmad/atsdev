<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
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
}
