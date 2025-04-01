<?php

namespace App\Providers;

use App\Models\Permission;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class PermissionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        try {
            // Cek apakah tabel permissions sudah ada
            if (Schema::hasTable('permissions')) {
                // Opsi Caching
                $useCache = config('permission.use_cache', true);
        
                try {
                    if ($useCache) {
                        $permissions = Cache::remember('permissions', 3600, function () {
                            return Permission::with('roles')->get();
                        });
                    } else {
                        $permissions = Permission::with('roles')->get();
                    }
        
                    // Auto-Define Gates
                    foreach ($permissions as $permission) {
                        Gate::define($permission->slug, function ($user) use ($permission) {
                            return $user->role->permissions->contains('slug', $permission->slug);
                        });
                    }
                } catch (\Exception $e) {
                    // Log error jika diperlukan
                    Log::error('Error while processing permissions: ' . $e->getMessage());
                    // Melompati proses ini dan melanjutkan eksekusi program
                    return;
                }
            }
        } catch (\Exception $e) {
            // Log error jika terjadi masalah saat pengecekan tabel
            Log::error('Error while checking permissions table: ' . $e->getMessage());
            // Melompati proses ini dan melanjutkan eksekusi program
            return;
        }
        
        // Cek apakah tabel permissions sudah ada
        // if (Schema::hasTable('permissions')) {
        //     // Opsi Caching
        //     $useCache = config('permission.use_cache', true);

        //     if ($useCache) {
        //         $permissions = Cache::remember('permissions', 3600, function () {
        //             return Permission::with('roles')->get();
        //         });
        //     } else {
        //         $permissions = Permission::with('roles')->get();
        //     }

        //     // Auto-Define Gates
        //     foreach ($permissions as $permission) {
        //         Gate::define($permission->slug, function ($user) use ($permission) {
        //             return $user->role->permissions->contains('slug', $permission->slug);
        //         });
        //     }
        // }
    }
}
