<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $locations = [
            ['location_name' => 'Library F1 R1', 'description' => 'Library Floor 1 Room 1'],
            ['location_name' => 'Library F1 R2', 'description' => 'Library Floor 1 Room 2'],
            ['location_name' => 'LR F2 R3', 'description' => 'Lecturer Room Floor 2 Room 3'],
            ['location_name' => 'LR F4 R3', 'description' => 'Lecturer Room Floor 4 Room 3'],
            ['location_name' => 'Library F1 R3', 'description' => 'Library Floor 1 Room 3'],
            ['location_name' => 'Lab F3 R1', 'description' => 'Laboratory Floor 3 Room 1'],
            ['location_name' => 'Lab F3 R2', 'description' => 'Laboratory Floor 3 Room 2'],
            ['location_name' => 'Auditorium F2 R1', 'description' => 'Auditorium Floor 2 Room 1'],
            ['location_name' => 'Cafeteria F1 R4', 'description' => 'Cafeteria Floor 1 Room 4'],
            ['location_name' => 'Meeting Room F2 R2', 'description' => 'Meeting Room Floor 2 Room 2'],
            ['location_name' => 'Studio F5 R1', 'description' => 'Studio Floor 5 Room 1'],
            ['location_name' => 'Gym F1 R5', 'description' => 'Gym Floor 1 Room 5'],
            ['location_name' => 'Workshop F4 R2', 'description' => 'Workshop Floor 4 Room 2'],
            ['location_name' => 'Archive Room F3 R3', 'description' => 'Archive Room Floor 3 Room 3'],
            ['location_name' => 'IT Room F2 R4', 'description' => 'IT Room Floor 2 Room 4'],
        ];

        // Menambahkan created_at dan updated_at ke setiap elemen
        $locations = array_map(function($item) {
            $item['created_at'] = now();
            $item['updated_at'] = now();
            return $item;
        }, $locations);

        Location::insert($locations);
        
    }
}
