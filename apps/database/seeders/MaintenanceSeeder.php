<?php

namespace Database\Seeders;

use App\Models\ItemAsset;
use App\Models\Maintenance;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MaintenanceSeeder extends Seeder
{
    public function run(): void
    {
        $maintenances = [];
        $documentCounter = 1;
        $documentSeries = 'A';
        $today = date('dmY'); // Format tanggal untuk kode maintenance

        // Ambil semua item assets yang tersedia
        $itemAssets = ItemAsset::all();

        if ($itemAssets->isEmpty()) {
            $this->command->warn('Skipping MaintenanceSeeder: No item assets found.');
            return;
        }

        for ($i = 1; $i <= 300; $i++) {
            $statusMainten = ['Reported', 'Proses', 'Finish'][rand(0, 2)];
            $dateMainten = ($statusMainten === 'reported') ? null : now()->addDays(rand(2, 4));

            // Pilih item asset secara acak
            $itemAsset = $itemAssets->random();

            // Format nomor urut (001 - 999), jika lebih dari 999, reset ke 001 dan naikkan seri dokumen
            $docNumber = str_pad($documentCounter, 3, '0', STR_PAD_LEFT);
            if ($documentCounter >= 999) {
                $documentCounter = 1;
                $documentSeries++;
            } else {
                $documentCounter++;
            }

            $maintenances[] = [
                'code_maintenance' => "MTN{$today}{$documentSeries}{$docNumber}",
                'item_asset_id' => $itemAsset->id,
                'vendor_id' => rand(1, 10),
                'master_asset_id' => $itemAsset->master_asset_id, // Sesuai dengan ItemAssetsSeeder
                'location_id' => $itemAsset->location_id, // Sesuai dengan ItemAssetsSeeder
                'date_mainten' => $dateMainten,
                'report_type' => ['Repair', 'Maintenance'][rand(0, 1)],
                'problem_detail' => "Problem detail for maintenance",
                'repaire_detail' => "Repair detail for maintenance",
                'cost' => rand(100000, 5000000),
                'status_mainten' => $statusMainten,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        Maintenance::insert($maintenances);
    }
}
