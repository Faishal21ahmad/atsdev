<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'role_name',
        'description',
    ];

    protected $dates = ['deleted_at'];
    /**
     * Relasi ke tabel users (one-to-many).
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function scopeActive($query)
    {
        return $query->whereNull('deleted_at');
    }
}
