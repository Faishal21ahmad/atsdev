<?php

namespace Database\Seeders;

use App\Models\FileMainten;
use Illuminate\Database\Seeder;

class FileMaintenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filemaintens = [
            ['maintenance_id' => 1, 'nameFile' => 'Default.jpg', 'type' => '1'],
            ['maintenance_id' => 1, 'nameFile' => 'Default.jpg', 'type' => '1'],
            ['maintenance_id' => 1, 'nameFile' => 'Default.jpg', 'type' => '1'],
            ['maintenance_id' => 1, 'nameFile' => 'Default.jpg', 'type' => '1'],
            ['maintenance_id' => 1, 'nameFile' => 'Default.jpg', 'type' => '2'],
            ['maintenance_id' => 1, 'nameFile' => 'Default.jpg', 'type' => '2'],
            ['maintenance_id' => 1, 'nameFile' => 'Default.jpg', 'type' => '2'],
            ['maintenance_id' => 1, 'nameFile' => 'Default.jpg', 'type' => '2'],
        ];

        $filemaintens = array_map(function ($item) {
            $item['created_at'] = now();
            $item['updated_at'] = now();
            return $item;
        }, $filemaintens);

        FileMainten::insert($filemaintens);
    }
}
