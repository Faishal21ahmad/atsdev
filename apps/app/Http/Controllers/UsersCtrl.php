<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UsersCtrl extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function showProfile()
    {
        $user = Auth::user();
        
        $data = [
            'title' => 'Profile',
            'profile' => $user,
            'user' => [
                'name' => $user->username,
                'role' => $user->department->department_name,
                ]
        ];

        return view('profile', $data);
    }

    public function actionUpdateProfile(Request $request){

        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255',
            'bio' => 'nullable|string|max:500'
        ], [
            'username.required' => 'Username tidak boleh kosong',
            'username.string' => 'Username harus berupa string',
            'username.max' => 'Username tidak boleh lebih dari 255 karakter',
            'bio.string' => 'bio harus berupa string',
            'bio.max' => 'bio tidak boleh lebih dari 500 karakter'
        ]);

         // Jika validasi gagal, kembalikan ke halaman sebelumnya dengan pesan error
        if ($validator->fails()) {
            return back()->with('alert', [
                'type' => 'danger',
                'messages' => $validator->errors()->all(),
            ])->onlyInput();
        }

        $users = Auth::user();
        // Update data profile
        $users->update([
            'username' => $request->username,
            'bio' => $request->bio,
            'updated_at' => now()
        ]);

        return redirect()->route('profile')->with('alert', [
            'type' => 'success',
            'message' => 'Profile berhasil diubah'
        ]);
    }


    public function actionForgotProfile(Request $request){
        $validator = Validator::make($request->all(), [
            'passwordOLD' => 'required|string',
            'newPassword' => 'required|string|min:8',
            'confirmPassword' => 'required|string|min:8'
        ], [
            'passwordOLD.required' => 'Password lama tidak boleh kosong',
            'passwordOLD.string' => 'Password lama harus berupa string',
            'newPassword.required' => 'Password baru tidak boleh kosong',
            'newPassword.string' => 'Password baru harus berupa string',
            'newPassword.min' => 'Password baru tidak boleh kurang dari 8 karakter',
            'confirmPassword.required' => 'Konfirmasi password tidak boleh kosong',
            'confirmPassword.string' => 'Konfirmasi password harus berupa string',
            'confirmPassword.min' => 'Konfirmasi password tidak boleh kurang dari 8 karakter'
        ]);

        // Jika validasi gagal, kembalikan ke halaman sebelumnya dengan pesan error
        if ($validator->fails()) {
            return back()->with('alert', [
                'type' => 'danger',
                'messages' => $validator->errors()->all(),
            ])->onlyInput();
        }
        $user = Auth::user();

        // Cek apakah password lama sesuai
        if (!Hash::check($request->passwordOLD, $user->password)) {
            return redirect()->route('profile')->with('alert', [
                'type' => 'danger',
                'messages' => ['Old password is incorrect!'],
            ]);
        }

        // Update password baru
        $user->update([
            'password' => Hash::make($request->newPassword),
            'updated_at' => now()
        ]);

        return redirect()->route('profile')->with('alert', [
            'type' => 'success',
            'messages' => ['Password berhasil diubah'],
        ]);
    }
}
