<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Department extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'department_name',
        'description',
    ];

    protected $dates = ['deleted_at'];

    // Relasi ke User
    public function users()
    {
        return $this->hasMany(User::class);
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

