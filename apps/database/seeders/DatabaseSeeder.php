<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolesSeeder::class,
            DepartmentsSeeder::class,
            // CategorySeeder::class,
            // VendorSeeder::class,
            // LocationSeeder::class,
            UsersTableSeeder::class,
            // MasterAssetSeeder::class,
            // CheckinSeeder::class,
            // CheckinMasterDetailSeeder::class,
            // CheckoutSeeder::class,
            // ItemAssetsSeeder::class,
            // MaintenanceSeeder::class,
            // FileMaintenSeeder::class,
            // UserOtpSeeder::class,
        ]);
    }
}
