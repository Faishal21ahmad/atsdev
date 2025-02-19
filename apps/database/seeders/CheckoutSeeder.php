<?php

namespace Database\Seeders;

use App\Models\Checkout;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CheckoutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $checkouts = [
            ['vendor_id' => 1, 'codecheckout' => 'CHO25052024A001', 'description' => 'Checkout for vendor 1'],
            ['vendor_id' => 2, 'codecheckout' => 'CHO25052024A002', 'description' => 'Checkout for vendor 2'],
            ['vendor_id' => 3, 'codecheckout' => 'CHO25052024A003', 'description' => 'Checkout for vendor 3'],
            ['vendor_id' => 4, 'codecheckout' => 'CHO25052024A004', 'description' => 'Checkout for vendor 4'],
            ['vendor_id' => 5, 'codecheckout' => 'CHO25052024A005', 'description' => 'Checkout for vendor 5'],
        ];

        // Menambahkan created_at dan updated_at ke setiap elemen
        $checkouts = array_map(function($item) {
            $item['created_at'] = now();
            $item['updated_at'] = now();
            return $item;
        }, $checkouts);
        
        Checkout::insert($checkouts);
        // foreach ($checkouts as $checkouts) {
        //     Checkout::create([
        //         'vendor_id' => $checkouts['vendor_id'],
        //         'codecheckout' => $checkouts['codecheckout'],
        //         'check_out_date' => $checkouts['check_out_date'],
        //         'description' => $checkouts['description']
        //     ]);
        // }
    }
}
