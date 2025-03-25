<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\RolesCtrl;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PermissionCtrl extends Controller
{
    public function showPermission($id) {
        $user = Auth::user();
        $roles = Role::where('id',$id)->firstOrFail();
        $permissions = Permission::all();

        $data = [
            'title' => 'Permission',
            'roles' => $roles,
            'permissions' => $permissions,
            'id' => $id,
            'user' => [
                'name' => $user->username,
                'role' => $user->department->department_name,
                ]
        ];
        return view('permission', $data);
    }

    public function syncPermissions(Request $request, $id) {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id', // Pastikan permission yang dikirim valid
        ], [
            'permissions.array' => 'Invalid permissions format.',
            'permissions.*.exists' => 'Permission not found.',
        ]);

        // Temukan role berdasarkan ID
        $role = Role::findOrFail($id);

        // Sync permissions ke tabel pivot
        $role->permissions()->sync($request->permissions);

        // Redirect dengan pesan sukses
        return redirect()->back()->with('alert', [
            'type' => 'success',
            'messages' => ['Permissions updated successfully.'],
        ]);
    }
}
