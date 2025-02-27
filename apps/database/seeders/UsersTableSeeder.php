<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {

        $pw = Hash::make('password');
        
        $users = [
            ['role_id' => 1, 'department_id' => 1, 'username' => 'ATS ADMIN', 'email' => 'atsintr2000@gmail.com', 'password' => $pw , 'is_active' => true, 'is_disable' => false],
            // ['role_id' => 2, 'department_id' => 3, 'username' => 'Ishal A', 'email' => 'isal2020ahmad@gmail.com', 'password' => $pw , 'is_active' => false, 'is_disable' => false],
            // ['role_id' => 2, 'department_id' => 2, 'username' => 'Freyana', 'email' => 'fre456@gmail.com', 'password' => $pw , 'is_active' => true, 'is_disable' => false],
            // ['role_id' => 2, 'department_id' => 4, 'username' => 'Bambang', 'email' => 'bam234@gmail.com', 'password' => $pw , 'is_active' => false, 'is_disable' => false],
            // ['role_id' => 3, 'department_id' => 5, 'username' => 'Dewi', 'email' => 'dew567@gmail.com', 'password' => $pw , 'is_active' => true, 'is_disable' => false],
            // ['role_id' => 3, 'department_id' => 1, 'username' => 'Rudi', 'email' => 'rud890@gmail.com', 'password' => $pw , 'is_active' => false, 'is_disable' => false],
            // ['role_id' => 3, 'department_id' => 2, 'username' => 'Sari', 'email' => 'sar123@gmail.com', 'password' => $pw , 'is_active' => true, 'is_disable' => false],
            // ['role_id' => 3, 'department_id' => 3, 'username' => 'Andi', 'email' => 'and456@gmail.com', 'password' => $pw , 'is_active' => true, 'is_disable' => false],
            // ['role_id' => 3, 'department_id' => 4, 'username' => 'Lina', 'email' => 'lin789@gmail.com', 'password' => $pw , 'is_active' => false, 'is_disable' => false],
            // ['role_id' => 3, 'department_id' => 5, 'username' => 'Hadi', 'email' => 'had234@gmail.com', 'password' => $pw , 'is_active' => true, 'is_disable' => false],
            // ['role_id' => 3, 'department_id' => 1, 'username' => 'Wati', 'email' => 'wat567@gmail.com', 'password' => $pw , 'is_active' => true, 'is_disable' => false],
            // ['role_id' => 3, 'department_id' => 2, 'username' => 'Tono', 'email' => 'ton890@gmail.com', 'password' => $pw , 'is_active' => false, 'is_disable' => false],
            // ['role_id' => 3, 'department_id' => 3, 'username' => 'Eka', 'email' => 'eka123@gmail.com', 'password' => $pw , 'is_active' => true, 'is_disable' => false],
            // ['role_id' => 3, 'department_id' => 4, 'username' => 'Budi', 'email' => 'bud456@gmail.com', 'password' => $pw , 'is_active' => true, 'is_disable' => false],
            // ['role_id' => 3, 'department_id' => 5, 'username' => 'Siti', 'email' => 'sit789@gmail.com', 'password' => $pw , 'is_active' => true, 'is_disable' => true],
        ];

        // Menambahkan created_at dan updated_at ke setiap elemen
        $users = array_map(function($item) {
            $item['created_at'] = now();
            $item['updated_at'] = now();
            return $item;
        }, $users);
        
        User::insert($users);
        
    }
}
