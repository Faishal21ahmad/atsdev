<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Role;
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
        $roles = Role::active()->get();
    
        $data = [
            'title' => 'Roles',
            'roles'  => $roles,
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
            'nameRole' => 'required',
            'description' => 'nullable',
        ], [
            'nameRole.required' => 'Name Role is required'
        ]);

        // Jika validasi gagal, kembalikan ke halaman sebelumnya dengan pesan error
        if ($validator->fails()) {
            return back()->with('alert', [
                'type' => 'danger',
                'messages' => $validator->errors()->all(),
            ])->onlyInput();
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
            'modalId' => 'required',
            'nameRole' => 'nullable',
            'description' => 'nullable'
        ], [
            'modalId.required' => 'Modal Id is required'
        ]);

        // Jika validasi gagal, kembalikan ke halaman sebelumnya dengan pesan error
        if ($validator->fails()) {
            return back()->with('alert', [
                'type' => 'danger',
                'messages' => $validator->errors()->all(),
            ])->onlyInput();
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
