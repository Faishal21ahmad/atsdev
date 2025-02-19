<?php

namespace Database\Seeders;
use App\Models\Role;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    public function run()
    {
        $roles = ['Admin', 'Manager', 'Employee'];

        foreach ($roles as $role) {
            Role::create([
                'role_name' => $role,
                'description' => "{$role} role description",
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
