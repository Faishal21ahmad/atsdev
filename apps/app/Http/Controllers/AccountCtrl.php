<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AccountCtrl extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function showAccount()
    {
        $user = Auth::user();
        $userall = User::getAllUsers();
        $dataRole = Role::active()->get();
        $dataDepartment = Department::active()->get();
        
        $data = [
            'title' => 'Account',
            'userall'  => $userall,
            'dataRole' => $dataRole,
            'dataDepartment' => $dataDepartment,
            'user' => [
                'name' => $user->username,
                'role' => $user->department->department_name,
                ]
        ];

        return view('account', $data);
    }

    // Create New Account
    public function actionAddAccount(Request $request){
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'email' => 'required', 
            'password' => 'required',
            'role' => 'required',
            'department' => 'required',
        ], [
            'username.required' => 'Username tidak boleh kosong',
            'email.required' => 'Email tidak boleh kosong',
            'password.required' => 'Password tidak boleh kosong',
            'role.required' => 'Role tidak boleh kosong',
            'department.required' => 'Department tidak boleh kosong',
        ]);
        
        // Jika validasi gagal, kembalikan ke halaman sebelumnya dengan pesan error
        if ($validator->fails()) {
            return back()->with('alert', [
                'type' => 'danger',
                'messages' => $validator->errors()->all(),
            ])->onlyInput();
        }

        $dataNewAccount = [
            'role_id' => $request->role,
            'department_id' => $request->department,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_active' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        User::insert($dataNewAccount);

        return redirect()->route('account')->with('alert', [
            'type' => 'success',
            'messages' => ['Pembuatan akun baru berhasil dilakukan'],
        ]);
    }


    public function actionUpdateAccount(Request $request){
        $validator = Validator::make($request->all(), [
            'modalId' => 'required',
            'username' => 'required',
            'role' => 'required',
            'department' => 'required',
        ], [
            'modalId.required' => 'ID tidak boleh kosong',
            'username.required' => 'Username tidak boleh kosong',
            'role.required' => 'Role tidak boleh kosong',
            'department.required' => 'Department tidak boleh kosong',
        ]);

        // Jika validasi gagal, kembalikan ke halaman sebelumnya dengan pesan error
        if ($validator->fails()) {
            return back()->with('alert', [
                'type' => 'danger',
                'messages' => $validator->errors()->all(),
            ])->onlyInput();
        }

        $dataUpdateAccount = [
            'role_id' => $request->role,
            'department_id' => $request->department,
            'username' => $request->username,
            'updated_at' => now(),
        ];

        User::where('id', $request->modalId)->update($dataUpdateAccount);

        return redirect()->route('account')->with('alert', [
            'type' => 'success',
            'messages' => ['Perubahan pada akun berhasil dilakukan'],
        ]);
    }

    public function actionResetPassword(Request $request){
        $validator = Validator::make($request->all(), [
            'ResetID' => 'required',
        ], [
            'ResetID.required' => 'ID tidak boleh kosong',
        ]);

        // Jika validasi gagal, kembalikan ke halaman sebelumnya dengan pesan error
        if ($validator->fails()) {
            return back()->with('alert', [
                'type' => 'danger',
                'messages' => $validator->errors()->all(),
            ])->onlyInput();
        }

        $dataUpdateAccount = [
            'password' => Hash::make('password'),
            'is_active' => 0,
            'updated_at' => now(),
        ];

        User::where('id', $request->ResetID)->update($dataUpdateAccount);

        return redirect()->route('account')->with('alert', [
            'type' => 'success',
            'messages' => ['Reset Account berhasil dilakukan'],
        ]);
    }

    public function actionDeleteAccount($id){
        User::where('id', $id)->delete();

        return redirect()->route('account')->with('alert', [
            'type' => 'success',
            'messages' => ['Hapus akun berhasil dilakukan'],
        ]);
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
