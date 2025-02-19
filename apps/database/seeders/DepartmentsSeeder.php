<?php

namespace Database\Seeders;
use App\Models\Department;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $departments = ['HR', 'Finance', 'IT', 'Marketing', 'Production'];

        foreach ($departments as $department) {
            Department::create([
                'department_name' => $department,
                'description' => "{$department} department description",
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
