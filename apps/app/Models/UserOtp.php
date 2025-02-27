<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserOtp extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'otp_code',
        'otp_expires',
        'purpose',
        'is_used',
    ];

    public static function validateAndUpdateOtp($otpCode, $userId)
    {
        // Cari OTP berdasarkan kode OTP dan user_id
        $otp = self::where('otp_code', $otpCode)
            ->first();

        // Jika OTP tidak ditemukan
        if (!$otp) {
            return [
                'success' => false,
                'message' => 'Kode OTP tidak valid.',
            ];
        }

        // Jika OTP sudah digunakan
        if ($otp->is_used) {
            return [
                'success' => false,
                'message' => 'Kode OTP sudah digunakan.',
            ];
        }

        // Jika OTP sudah kadaluarsa
        if ($otp->otp_expires <= now()) {
            $otp->update([
                'otp_code' => null,
                'is_used' => true,
                'purpose' => "vf_expired",
            ]);
            return [
                'success' => false,
                'message' => 'Kode OTP sudah kadaluarsa.',
            ];
        }

        $otp->update([
            'otp_code' => null,
            'is_used' => true,
        ]);

        return [
            'success' => true,
            'message' => 'OTP valid.',
            'purpose' => $otp->purpose,
        ];
    }

    // Fungsi untuk generate OTP dan menyimpannya ke database
    public static function generateOtp($userId, $purpose)
    {
        $otpCode = rand(100000, 999999); // Buat kode OTP 6 digit
        $otpExpires = now()->addMinutes(10); // Masa berlaku OTP

        $otp = self::create([
            'user_id' => $userId,
            'otp_code' => $otpCode,
            'otp_expires' => $otpExpires,
            'purpose' => $purpose,
        ]);

        return $otp->otp_code; // Mengembalikan data OTP yang baru dibuat
    }

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
