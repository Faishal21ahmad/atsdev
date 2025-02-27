<?php

namespace Database\Seeders;

use App\Models\UserOtp;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserOtpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $UserOtps = [
            ['user_id' => 1, 'otp_code' => '123456', 'otp_expires' => '2024-01-01 12:00:00', 'purpose' => 'login', 'is_used' => true],
            ['user_id' => 2, 'otp_code' => '654321', 'otp_expires' => '2024-01-02 12:00:00', 'purpose' => 'reset_password', 'is_used' => false],
            ['user_id' => 3, 'otp_code' => null, 'otp_expires' => '2024-01-03 12:00:00', 'purpose' => 'login', 'is_used' => true], // OTP sudah digunakan
            ['user_id' => 4, 'otp_code' => '987654', 'otp_expires' => '2024-01-04 12:00:00', 'purpose' => 'verify_email', 'is_used' => false],
            ['user_id' => 5, 'otp_code' => null, 'otp_expires' => '2024-01-05 12:00:00', 'purpose' => 'reset_password', 'is_used' => true], // OTP sudah digunakan
            ['user_id' => 6, 'otp_code' => '456789', 'otp_expires' => '2024-01-06 12:00:00', 'purpose' => 'login', 'is_used' => false],
            ['user_id' => 7, 'otp_code' => null, 'otp_expires' => '2024-01-07 12:00:00', 'purpose' => 'verify_email', 'is_used' => true], // OTP sudah digunakan
            ['user_id' => 8, 'otp_code' => '321654', 'otp_expires' => '2024-01-08 12:00:00', 'purpose' => 'reset_password', 'is_used' => false],
            ['user_id' => 9, 'otp_code' => null, 'otp_expires' => '2024-01-09 12:00:00', 'purpose' => 'login', 'is_used' => true], // OTP sudah digunakan
            ['user_id' => 10, 'otp_code' => '789123', 'otp_expires' => '2024-01-10 12:00:00', 'purpose' => 'verify_email', 'is_used' => false],
        ];

        // Menambahkan created_at dan updated_at ke setiap elemen
        $UserOtps = array_map(function($item) {
            $item['created_at'] = now();
            $item['updated_at'] = now();
            return $item;
        }, $UserOtps);

        UserOtp::insert($UserOtps);
    }
}
