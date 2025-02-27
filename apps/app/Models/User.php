<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'role_id',
        'department_id',
        'username',
        'email',
        'password',
        'bio',
        'is_active',
        'is_disable'
    ];

    protected $dates = ['deleted_at'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

     // Relasi ke Role
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // Relasi ke Department
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    // Relasi ke UserOtp
    public function otps()
    {
        return $this->hasMany(UserOtp::class);
    }

    public static function getAllUsers()
    {
        return self::select('id', 'role_id', 'department_id', 'username', 'email', 'is_active','is_disable', 'created_at', 'updated_at')->whereNull('deleted_at')->get();
    }

    public static function checkisActive($email)
    {
        $stats = self::select('is_active')->where('email', $email)->first();
        if ($stats->is_active) {
            return true;
        } else {
            return false;
        }
    }
    public static function checkisDisable($email)
    {
        $stats = self::select('is_disable')->where('email', $email)->first();
        if ($stats->is_disable) {
            return true;
        } else {
            return false;
        }
    }
}
