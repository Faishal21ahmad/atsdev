<?php

namespace App\Models;

use App\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Permission extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'slug',
        'permission_name',
    ];
    // Relasi ke Role
    public function roles() {
        return $this->belongsToMany(Role::class, 'permission_role')->withPivot('role_id');
    }

    
    public static function getPermissionClear() {
        return self::select('id', 'permission_name')->get();
    }

}
