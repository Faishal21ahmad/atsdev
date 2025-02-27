<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Role;
use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Imports\AccountsImport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
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

    public function actionResetAccount(Request $request){
        $validator = Validator::make($request->all(), [
            'idexedata' => 'required',
        ], [
            'idexedata.required' => 'ID tidak boleh kosong',
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

        User::where('id', $request->idexedata)->update($dataUpdateAccount);

        return redirect()->route('account')->with('alert', [
            'type' => 'success',
            'messages' => ['Reset Account berhasil dilakukan'],
        ]);
    }
    public function actionDisableAccount(Request $request){
        $validator = Validator::make($request->all(), [
            'idexedata' => 'required',
        ], [
            'idexedata.required' => 'ID tidak boleh kosong',
        ]);

        // Jika validasi gagal, kembalikan ke halaman sebelumnya dengan pesan error
        if ($validator->fails()) {
            return back()->with('alert', [
                'type' => 'danger',
                'messages' => $validator->errors()->all(),
            ])->onlyInput();
        }

        $dataUpdateAccount = [
            'is_active' => 0,
            'is_disable' => 1,
            'updated_at' => now(),
        ];

        User::where('id', $request->idexedata)->update($dataUpdateAccount);

        return redirect()->route('account')->with('alert', [
            'type' => 'success',
            'messages' => ['Disable Account berhasil dilakukan'],
        ]);
    }

    public function actionEnableAccount(Request $request){
        $validator = Validator::make($request->all(), [
            'idexedata' => 'required',
        ], [
            'idexedata.required' => 'ID tidak boleh kosong',
        ]);

        // Jika validasi gagal, kembalikan ke halaman sebelumnya dengan pesan error
        if ($validator->fails()) {
            return back()->with('alert', [
                'type' => 'danger',
                'messages' => $validator->errors()->all(),
            ])->onlyInput();
        }

        $dataUpdateAccount = [
            'is_disable' => 0,
            'updated_at' => now(),
        ];

        User::where('id', $request->idexedata)->update($dataUpdateAccount);

        return redirect()->route('account')->with('alert', [
            'type' => 'success',
            'messages' => ['Enable Account berhasil dilakukan'],
        ]);
    }


    public function actionDeleteAccount(Request $request){
        $validator = Validator::make($request->all(), [
            'deleteID' =>'required',
        ], [
            'deleteID.required' => 'ID tidak boleh kosong',
        ]);
         // Jika validasi gagal, kembalikan ke halaman sebelumnya dengan pesan error
        if ($validator->fails()) {
            return back()->with('alert', [
                'type' => 'danger',
                'messages' => $validator->errors()->all(),
            ])->onlyInput();
        }

        User::where('id', $request->deleteID)->delete();

        return redirect()->route('account')->with('alert', [
            'type' => 'success',
            'messages' => ['Hapus akun berhasil dilakukan'],
        ]);
    }

    public function importAccountExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        try {
            Excel::import(new AccountsImport, $request->file('file'));
            return back()->with('alert', [
                'type' => 'success',
                'messages' => ['Data berhasil diimport!'],
            ]);
        } catch (Exception $e) {
            return back()->with('alert', [
                'type' => 'danger',
                'messages' => ['Import Gagal', $e->getMessage()],
            ]);
        }
    }
}
