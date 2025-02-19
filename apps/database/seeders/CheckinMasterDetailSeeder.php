<?php

namespace Database\Seeders;

use App\Models\CheckinMasterDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CheckinMasterDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $checkindetails = [
            ['check_in_id' => 1, 'master_asset_id' => 1, 'quantity' => 5, 'unit_price' => 1500000, 'sub_total' => 7500000],
            ['check_in_id' => 1, 'master_asset_id' => 2, 'quantity' => 3, 'unit_price' => 2000000, 'sub_total' => 6000000],
            ['check_in_id' => 2, 'master_asset_id' => 3, 'quantity' => 4, 'unit_price' => 1200000, 'sub_total' => 4800000],
        ];

        // Menambahkan created_at dan updated_at ke setiap elemen
        $checkindetails = array_map(function($item) {
            $item['created_at'] = now();
            $item['updated_at'] = now();
            return $item;
        }, $checkindetails);

        CheckinMasterDetail::insert($checkindetails);

        // foreach ($checkindetails as $checkindetail) {
        //     CheckinMasterDetail::create([
        //         'check_in_id' => $checkindetail['check_in_id'],
        //         'master_asset_id' => $checkindetail['master_asset_id'],
        //         'quantity' => $checkindetail['quantity'],
        //         'unit_price' => $checkindetail['unit_price'],
        //         'total_price' => $checkindetail['total_price']
        //     ]);
        // }
    }
}
