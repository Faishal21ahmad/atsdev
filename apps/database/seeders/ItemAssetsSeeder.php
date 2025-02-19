<?php

namespace Database\Seeders;

use App\Models\ItemAsset;
use Illuminate\Support\Str;
use App\Services\DocService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ItemAssetsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Storage::deleteDirectory('fileQR'); 
        Storage::makeDirectory('fileQR');
        $itemAssets = [];
        $totalCheckedOut = 30; // Jumlah item asset yang akan di-set checked_out
        $checkedOutIndices = array_rand(range(0, 149), $totalCheckedOut); // Ambil 30 indeks secara acak

        for ($i = 1; $i <= 15; $i++) {
            for ($j = 1; $j <= 10; $j++) {
                $index = (($i - 1) * 10) + ($j - 1);
                $isCheckedOut = in_array($index, (array) $checkedOutIndices);
                $codeAssets = DocService::generateCodeAssets();

                $qrPath = 'fileQR/' . $codeAssets . '.svg';
                QrCode::size(300)->format('svg')->generate($codeAssets, storage_path('app/public/' . $qrPath));


                $itemAssets[] = [
                    'master_asset_id' => $i,
                    'checkin_master_detail_id' => ($i <= 3) ? 1 : 2,
                    'location_id' => rand(1, 15),
                    'department_id' => rand(1, 5),
                    'vendor_id' => rand(1, 10),
                    'check_out_id' => $isCheckedOut ? rand(1, 5) : null, // Jika termasuk 30 data, isi check_out_id
                    'code_assets' => $codeAssets, // Gunakan format baru
                    'description' => 'Asset description for ' . $codeAssets,
                    'condition' => 'New',
                    'status' => $isCheckedOut ? 'Checked_out' : 'Available', // Jika check_out_id ada, status menjadi 'checked_out'
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        ItemAsset::insert($itemAssets);
    }
}
