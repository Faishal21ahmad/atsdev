<?php

namespace Database\Seeders;

use App\Models\MasterAsset;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MasterAssetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $masterAssets = [
            ['category_id' => 1, 'asset_name' => 'Lenovo L22i', 'interval_maintence' => 12,'min_stock' => 5,'current_stock' => 10,'image_name' => null,'description' => 'High-performance monitor for employees'],
            ['category_id' => 1, 'asset_name' => 'Dell UltraSharp U2722D','interval_maintence' => 12,'min_stock' => 3,'current_stock' => 10,'image_name' => null,'description' => '27-inch 4K monitor with color accuracy'],
            ['category_id' => 1, 'asset_name' => 'HP EliteDisplay E243','interval_maintence' => 12,'min_stock' => 4,'current_stock' => 10,'image_name' => null,'description' => '24-inch monitor for office use'],
            ['category_id' => 2, 'asset_name' => 'Asus ZenBook 14','interval_maintence' => 6,'min_stock' => 2,'current_stock' => 10,'image_name' => null,'description' => 'Ultra-slim laptop for professionals'],
            ['category_id' => 2, 'asset_name' => 'Dell XPS 13','interval_maintence' => 6,'min_stock' => 3,'current_stock' => 10,'image_name' => null,'description' => 'Compact and powerful laptop'],
            ['category_id' => 2, 'asset_name' => 'MacBook Air M2','interval_maintence' => 6,'min_stock' => 2,'current_stock' => 10,'image_name' => null,'description' => 'Lightweight laptop with Apple Silicon'],
            ['category_id' => 3, 'asset_name' => 'Meja Kantor Minimalis','interval_maintence' => 24,'min_stock' => 10,'current_stock' => 10,'image_name' => null,'description' => 'Minimalist office desk'],
            ['category_id' => 3, 'asset_name' => 'Meja Meeting Besar','interval_maintence' => 24,'min_stock' => 5,'current_stock' => 10,'image_name' => null,'description' => 'Large meeting table'],
            ['category_id' => 3, 'asset_name' => 'Meja Kerja Adjustable','interval_maintence' => 24,'min_stock' => 8,'current_stock' => 10,'image_name' => null,'description' => 'Adjustable height desk'],
            ['category_id' => 4, 'asset_name' => 'Canon EOS R5','interval_maintence' => 12,'min_stock' => 2,'current_stock' => 10,'image_name' => null,'description' => 'Professional mirrorless camera'],
            ['category_id' => 4, 'asset_name' => 'Sony A7 III','interval_maintence' => 12,'min_stock' => 3,'current_stock' => 10,'image_name' => null,'description' => 'Full-frame mirrorless camera'],
            ['category_id' => 4, 'asset_name' => 'Nikon Z6 II','interval_maintence' => 12,'min_stock' => 2,'current_stock' => 10,'image_name' => null,'description' => 'Versatile mirrorless camera'],
            ['category_id' => 5, 'asset_name' => 'Dell OptiPlex 3080','interval_maintence' => 12,'min_stock' => 5,'current_stock' => 10,'image_name' => null,'description' => 'Office desktop computer'],
            ['category_id' => 5, 'asset_name' => 'HP ProDesk 400 G6','interval_maintence' => 12,'min_stock' => 4,'current_stock' => 10,'image_name' => null,'description' => 'Compact business desktop'],
            ['category_id' => 5, 'asset_name' => 'Lenovo ThinkCentre M75q','interval_maintence' => 12,'min_stock' => 3,'current_stock' => 10,'image_name' => null,'description' => 'Tiny desktop for office use'],
        ];

        // Menambahkan created_at dan updated_at ke setiap elemen dan slug
        $masterAssets = array_map(function ($item) {
            $slug = Str::slug($item['asset_name']);
            $count = MasterAsset::where('slug', 'LIKE', "$slug%")->count();
            $item['slug'] = $count ? "$slug-" . ($count + 1) : $slug;
            $item['created_at'] = now();
            $item['updated_at'] = now();
            return $item;
        }, $masterAssets);

        MasterAsset::insert($masterAssets);
    }
}
