<?php

namespace Database\Seeders;

use App\Models\Vendor;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class VendorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vendors = [
            ['vendor_name' => 'PT. Maju Jaya Abadi', 'contact' => '081200000001', 'address' => 'Jl. Sudirman No. 123, Jakarta', 'description' => 'Vendor description'],
            ['vendor_name' => 'CV. Sejahtera Bersama', 'contact' => '081200000002', 'address' => 'Jl. Thamrin No. 45, Bandung', 'description' => 'Vendor description'],
            ['vendor_name' => 'UD. Makmur Sentosa', 'contact' => '081200000003', 'address' => 'Jl. Gatot Subroto No. 67, Surabaya', 'description' => 'Vendor description'],
            ['vendor_name' => 'PT. Barokah Jaya IT', 'contact' => '081200000004', 'address' => 'Jl. Pemuda No. 89, Yogyakarta', 'description' => 'Vendor description'],
            ['vendor_name' => 'CV. Cemerlang Pratama', 'contact' => '081200000005', 'address' => 'Jl. Merdeka No. 101, Medan', 'description' => 'Vendor description'],
            ['vendor_name' => 'PT. Teknologi Canggih', 'contact' => '081200000006', 'address' => 'Jl. Gatot Subroto No. 10, Semarang', 'description' => 'Vendor description'],
            ['vendor_name' => 'CV. Mandiri Jaya', 'contact' => '081200000007', 'address' => 'Jl. Pahlawan No. 20, Malang', 'description' => 'Vendor description'],
            ['vendor_name' => 'PT. Sinar Terang', 'contact' => '081200000008', 'address' => 'Jl. Merdeka No. 30, Surabaya', 'description' => 'Vendor description'],
            ['vendor_name' => 'UD. Cahaya Baru', 'contact' => '081200000009', 'address' => 'Jl. Diponegoro No. 40, Yogyakarta', 'description' => 'Vendor description'],
            ['vendor_name' => 'PT. Maju Bersama', 'contact' => '081200000010', 'address' => 'Jl. Sudirman No. 50, Jakarta', 'description' => 'Vendor description'],
        ];

        // Menambahkan created_at dan updated_at ke setiap elemen
        $vendors = array_map(function($item) {
            $item['created_at'] = now();
            $item['updated_at'] = now();
            return $item;
        }, $vendors);
        
        Vendor::insert($vendors);

        // foreach ($vendors as $vendor) {
        //     Vendor::create([
        //         'vendor_name' => $vendor['name'],
        //         'contact' => $vendor['contact'],
        //         'address' => $vendor['address'],
        //         'description' => $vendor['description'],
        //     ]);
        // }
    }
}
