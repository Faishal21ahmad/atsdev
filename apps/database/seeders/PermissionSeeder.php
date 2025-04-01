<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissionFitur = [
            // ['permission_name' => 'Create Data'],
            // ['permission_name' => 'Import Data'],
            // ['permission_name' => 'Edit Data'],
            // ['permission_name' => 'Delete Data'],

            ['permission_name' => 'Asset Management'],
            ['permission_name' => 'Detail Master Asset'],
            ['permission_name' => 'Edit Master Asset'],
            ['permission_name' => 'PrintQR Master Asset'],
            ['permission_name' => 'Detail Item Asset'],
            ['permission_name' => 'Edit Item Asset'],
            ['permission_name' => 'PrintQR Item Asset'],
            ['permission_name' => 'Scan Item Asset'],
            ['permission_name' => 'Checkin'],
            ['permission_name' => 'Checkout'],
            
            ['permission_name' => 'Category Management'],
            ['permission_name' => 'Edit Category'],
            ['permission_name' => 'Delete Category'],
            ['permission_name' => 'Add Category'],
            ['permission_name' => 'Import Category'],

            ['permission_name' => 'Location Management'],
            ['permission_name' => 'Edit Location'],
            ['permission_name' => 'Delete Location'],
            ['permission_name' => 'Add Location'],
            ['permission_name' => 'Import Location'],

            ['permission_name' => 'Department Management'],
            ['permission_name' => 'Edit Department'],
            ['permission_name' => 'Delete Department'],
            ['permission_name' => 'Add Department'],
            ['permission_name' => 'Import Department'],

            ['permission_name' => 'Vendor Management'],
            ['permission_name' => 'Edit Vendor'],
            ['permission_name' => 'Delete Vendor'],
            ['permission_name' => 'Add Vendor'],
            ['permission_name' => 'Import Vendor'],

            ['permission_name' => 'Maintenance Management'],
            ['permission_name' => 'Maintenance Schedule'],
            ['permission_name' => 'Scan Maintenance Report'],
            ['permission_name' => 'Refresh Schaduler Maintenance'],
            ['permission_name' => 'Report Maintenance'],
            ['permission_name' => 'Resolve Maintenance'],
            ['permission_name' => 'Detail Maintenance'],

            ['permission_name' => 'Role Management'],
            ['permission_name' => 'Role Permission Management'],
            ['permission_name' => 'Edit Role'],
            ['permission_name' => 'Delete Role'],
            ['permission_name' => 'Add Role'],
            ['permission_name' => 'Import Role'],

            ['permission_name' => 'Account Management'],
            ['permission_name' => 'Disable Account'],
            ['permission_name' => 'Reset Account'],
            ['permission_name' => 'Edit Account'],
            ['permission_name' => 'Delete Account'],
            ['permission_name' => 'Add Account'],
            ['permission_name' => 'Import Account'],

            ['permission_name' => 'Audit Management'],
            
        ];

        $permissionFitur = array_map(function ($item){
            $slug = Str::slug($item['permission_name']);
            $count = Permission::where('slug', 'LIKE', "$slug%")->count();
            $item['slug'] = $count ? "$slug-" . ($count + 1) : $slug;
            $item['created_at'] = now();
            $item['updated_at'] = now();
            return $item;
        }, $permissionFitur);

        Permission::insert($permissionFitur);

        // 3. Assign Permission ke Role
        $superAdmin = Role::where('role_name', 'Super Admin')->first();
        $superAdmin->permissions()->attach(Permission::all());

        $admin = Role::where('role_name', 'Admin')->first();
        $admin->permissions()->attach(
            Permission::whereIn('slug', [
                'asset-management',
                'detail-master-asset',
                'edit-master-asset',
                'printqr-master-asset',
                'detail-item-asset',
                'edit-item-asset',
                'printqr-item-asset',
                'scan-item-asset',
                'checkin',
                'checkout',
                'category-management',
                'edit-category',
                'delete-category',
                'add-category',
                'import-category',
                'location-management',
                'edit-location',
                'delete-location',
                'add-location',
                'import-location',
                'department-management',
                'edit-department',
                'delete-department',
                'add-department',
                'import-department',
                'vendor-management',
                'edit-vendor',
                'delete-vendor',
                'add-vendor',
                'import-vendor',
                'maintenance-management',
                'maintenance-schedule',
                'scan-maintenance-report',
                'refresh-scheduler-maintenance',
                'report-maintenance',
                'resolve-maintenance',
                'detail-maintenance',
                'account-management',
                'disable-account',
                'reset-account',
                'edit-account',
                'add-account',
                'import-account',
                'audit-management',
            ])->pluck('id')
        );

        $manager = Role::where('role_name', 'Manager')->first();
        $manager->permissions()->attach(
            Permission::whereIn('slug', [
                'asset-management',
                'detail-master-asset',
                'edit-master-asset',
                'printqr-master-asset',
                'detail-item-asset',
                'edit-item-asset',
                'printqr-item-asset',
                'scan-item-asset',
                'checkin',
                'checkout',
                'category-management',
                'edit-category',
                'delete-category',
                'add-category',
                'import-category',
                'location-management',
                'edit-location',
                'delete-location',
                'add-location',
                'import-location',
                'department-management',
                'edit-department',
                'delete-department',
                'add-department',
                'import-department',
                'vendor-management',
                'edit-vendor',
                'delete-vendor',
                'add-vendor',
                'import-vendor',
                'maintenance-management',
                'maintenance-schedule',
                'scan-maintenance-report',
                'refresh-scheduler-maintenance',
                'report-maintenance',
                'resolve-maintenance',
                'detail-maintenance',
            ])->pluck('id')
        );

        $employee = Role::where('role_name', 'Employee')->first();
        $employee->permissions()->attach(
            Permission::whereIn('slug', [
                'asset-management',
                'detail-master-asset',
                'edit-master-asset',
                'printqr-master-asset',
                'detail-item-asset',
                'edit-item-asset',
                'printqr-item-asset',
                'scan-item-asset',
                'checkin',
                'checkout',
                'category-management',
                'edit-category',
                'add-category',
                'location-management',
                'edit-location',
                'add-location',
                'department-management',
                'edit-department',
                'add-department',
                'vendor-management',
                'edit-vendor',
                'add-vendor',
                'maintenance-management',
                'maintenance-schedule',
                'scan-maintenance-report',
                'refresh-scheduler-maintenance',
                'report-maintenance',
                'resolve-maintenance',
                'detail-maintenance',
            ])->pluck('id')
        );
    }
}
