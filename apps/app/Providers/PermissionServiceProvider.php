<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use App\Models\Permission;

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
        // Cek apakah tabel permissions sudah ada
        if (Schema::hasTable('permissions')) {
            // Opsi Caching
            $useCache = config('permission.use_cache', true);

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
        }
    }
}
