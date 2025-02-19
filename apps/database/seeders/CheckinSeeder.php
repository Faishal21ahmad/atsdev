<?php

namespace Database\Seeders;

use App\Models\Checkin;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CheckinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $checkins = [
            ['codecheckin' => 'CHI25052024A001', 'description' => 'Initial checkin for new assets','total' => 4000000],
            ['codecheckin' => 'CHI25052024A002', 'description' => 'Checkin for additional assets','total' => 4000000],
        ];

        // Menambahkan created_at dan updated_at ke setiap elemen
        $checkins = array_map(function($item) {
            $item['created_at'] = now();
            $item['updated_at'] = now();
            return $item;
        }, $checkins);

        Checkin::insert($checkins);
        // foreach ($checkins as $checkin) {
        //     Checkin::create([
        //         'codecheckin' => $checkin['codecheckin'],
        //         'checkin_date' => $checkin['checkin_date'],
        //         'description' => $checkin['description']
        //     ]);
        // }
    }
}
