<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Category;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RolesCtrl extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function showRoles()
    {
        $user = Auth::user();
        $permissionClear = Permission::getPermissionClear();
        $roles = Role::all();
        $permissions = Permission::all();
        $data = [
            'title' => 'Roles',
            'roles'  => $roles,
            'permissions' => $permissions,
            'permissionClear' => $permissionClear,
            'user' => [
                'name' => $user->username,
                'role' => $user->department->department_name,
                ]
        ];
        return view('role', $data);
    }

    // ** Action add Roles **
    public function actionAddRole(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nameRole' => 'required|max:60',
            'description' => 'nullable|max:300',
        ], [
            'nameRole.required' => 'Name Role is required',
            'nameRole.max' => 'Name Role maximal 60 characters',
            'description.max' => 'Description maximal 300 characters'
        ]);

        // Jika validasi gagal, kembalikan ke halaman sebelumnya dengan pesan error
        if ($validator->fails()) {
            return back()->with('alert', [
                'type' => 'danger',
                'messages' => $validator->errors()->all(),
            ]);
        }

        $dataRole = [
            'role_name' => $request->nameRole,
            'description' => $request->description,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        Role::create($dataRole);

        return redirect()->route('role')->with('alert', [
            'type' => 'success',
            'messages' => ['Role Berhasil ditambahkan !!'],
        ]);
    }

    // ** Action Update Roles **
    public function actionUpdateRole(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'modalId' => 'required|numeric',
            'nameRole' => 'nullable|max:60',
            'description' => 'nullable|max:300',
        ], [
            'modalId.required' => 'Role is required',
            'modalId.numeric' => 'Role is not valid',
            'nameRole.max' => 'Name Role maximal 60 characters',
            'description.max' => 'Description maximal 300 characters'
        ]);

        // Jika validasi gagal, kembalikan ke halaman sebelumnya dengan pesan error
        if ($validator->fails()) {
            return back()->with('alert', [
                'type' => 'danger',
                'messages' => $validator->errors()->all(),
            ]);
        }

        $dataRole = [
            'role_name' => $request->nameRole,
            'description' => $request->description,
            'updated_at' => now(),
        ];
        Role::where('id', $request->modalId)->update($dataRole);

        return redirect()->route('role')->with('alert', [
            'type' => 'success',
            'messages' => ['Role Berhasil diubah !!'],
        ]);
    }

    // ** Action Delete Roles **
    public function actionDeleteRole(string $id)
    {
        $Role = Role::find($id);

        if (!$Role) {
            return redirect()->back()->with('alert', [
                'type' => 'danger',
                'messages' => ['Role not found.'],
            ]);
            
        }
        // Hapus dengan soft delete
        $Role->delete();

        return redirect()->route('role')->with('alert', [
            'type' => 'success',
            'messages' => ['Role deleted !!'],
        ]);
    }
}
