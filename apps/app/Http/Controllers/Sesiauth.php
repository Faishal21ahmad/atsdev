<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Mail\SendOtp;
use App\Models\UserOtp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;


class Sesiauth extends Controller
{
    /**
     * Tampilkan form login.
     */
    public function showLoginForm()
    {
        $data = [
            'title' => 'Login'
        ];
        return view('login', $data);
    }

    /**
     * Proses login.
     */
    public function login(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Email wajib diisi .',
            'email.email' => 'Email tidak valid .',
            'password.required' => 'Password wajib diisi .',
        ]);
        // Jika validasi gagal, kembalikan ke halaman sebelumnya dengan pesan error
        if ($validator->fails()) {
            return back()->with('alert', [
                'type' => 'danger',
                'messages' => $validator->errors()->all(),
            ])->onlyInput();
        }

        $user = User::where('email', $request->email)->first();
        // Cek apakah email terdaftar
        if (!$user) {
            return back()->with('alert', [
                'type' => 'danger',
                'messages' => ['Email tidak terdaftar.'],
            ])->onlyInput('email');
        }
        // Cek apakah account is_disable
        if ($user->is_disable) {
            return back()->with('alert', [
                'type' => 'danger',
                'messages' => ['Akun Anda dinonaktifkan. Harap hubungi administrator.'],
            ])->onlyInput('email');
        }
        // Cek apakah account is_active
        if (!$user->is_active) {
            //  Jika akun belum aktif, generate OTP melalui Model
            $otp = UserOtp::generateOtp($user->id, 'verify_email');
            session(['email' => $user->email]);

            // Mail::to($user->email)->send(new SendOtp($otp));
            return redirect()->route('otp.form')->with('alert', [
                'type' => 'alert',
                'messages' => ['Hai, ' . $user->username . ' Akun mu belum aktif !!','Masukkan OTP yang telah dikirimkan ke email Anda.'],
            ]);
        }

        // Coba autentikasi
        if (Auth::attempt($validator->validated())) {
            return redirect()->route('dashboard')->with('alert', [
                'type' => 'success',
                'messages' => ['Login berhasil! ',' Selamat datang ' . $user->username ],
            ]);
        }
        return back()->with('alert', [
            'type' => 'danger',
            'messages' => ['Pastikan email dan password Anda sesuai.'],
        ])->onlyInput('email');
    }

    /**
     * Tampilkan form OTP.
     */
    public function showOtpForm()
    {
        $data = [
            'title' => 'OTP',
        ];
        return view('otp', $data);
    }
    
    /**
     * Validasi OTP.
     */
    public function validateOtp(Request $request)
    {
        // Validasi input OTP
        $validator = Validator::make($request->all(), [
            'otpfull' => 'required|numeric',
        ], [
            'otpfull.required' => 'Email wajib diisi server.',
            'otpfull.numeric' => 'Email tidak valid server.',
        ]);

        // Jika validasi gagal, kembalikan ke halaman sebelumnya dengan pesan error
        if ($validator->fails()) {
            return back()->with('alert', [
                'type' => 'danger',
                'messages' => $validator->errors()->all(),
            ])->onlyInput();
        }

        // Cari user berdasarkan email
        $user = User::where('email', session()->get('email'))->first();

        // Panggil method di model UserOtp untuk validasi dan update OTP
        $otpValidationResult = UserOtp::validateAndUpdateOtp($request->otpfull, $user->id);

        // Jika validasi gagal, kembalikan pesan error
        if (!$otpValidationResult['success']) {
            return back()->with('alert', [
                'type' => 'danger',
                'messages' => [$otpValidationResult['message']],
            ]);
        }

        // Update data user di tabel User: set is_active menjadi true
        User::where('id', $user->id)->update([
            'is_active' => true,
        ]);

        if($otpValidationResult['purpose'] == 'verify_email') {
            session()->forget('email');
            $route = 'login';
            $messages = ['Akun Anda berhasil diaktifkan.','Silahkan login kembali.'];
        } elseif ($otpValidationResult['purpose'] == 'forgot_password') {
            $route = 'show.forgot.password';
            $messages = ['OTP Berhasil di verifikasi.'];
        }

        return redirect()->route($route)->with('alert', [
            'type' => 'success',
            'messages' => $messages,
        ]);
    }

    /**
     * Tampilkan form konfirmasi email.
     */
    public function showConfirmEmail()
    {
        $data = [
            'title' => 'Konfirmasi Email',
        ];
        return view('confirmEmail', $data);
    }

    // Proses konfirmasi email.
    public function actionConfirmEmail(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Email tidak valid.',
        ]);

        // Jika validasi gagal, kembalikan ke halaman sebelumnya dengan pesan error
        if ($validator->fails()) {
            return back()->with('alert', [
                'type' => 'danger',
                'messages' => $validator->errors()->all(),
            ])->onlyInput();
        }

        // Cari user berdasarkan email
        $user = User::where('email', $request->email)->first();

        // Jika user tidak ditemukan
        if (!$user) {
            return back()->with('alert', [
                'type' => 'danger',
                'messages' => ['Email tidak terdaftar.'],
            ])->onlyInput('email');
        }

        // Jika user is_disable
        if ($user->is_disable) {
            return back()->with('alert', [
                'type' => 'danger',
                'messages' => ['Akun Anda dinonaktifkan. Harap hubungi administrator.'],
            ])->onlyInput('email');
        }

        session(['email' => $request->email]);

        // Generate OTP
        $otp = UserOtp::generateOtp($user->id, 'forgot_password');

        // Kirim email
        // Mail::to($user->email)->send(new SendOtp($otp));

        return redirect()->route('otp.form')->with('alert', [
            'type' => 'success',
            'messages' => ['Masukkan OTP yang telah dikirimkan ke email Anda.'],
        ]);
    }

    /**
     * Tampilkan form lupa password.
     */
    public function showForgotPassword()
    {
        $data = [
            'title' => 'Lupa Password',
        ];
        return view('forgotpassword', $data);
    }

    /**
     * Proses lupa password.
     */
    public function actionForgotPassword(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'newPassword' =>'required',
            'passwordConfirm' => 'required',
        ], [
            'newPassword.required' => 'New Password wajib diisi.',
            'passwordConfirm.required' => 'Confirm Password wajib diisi.',
        ]);
        // Jika validasi gagal, kembalikan ke halaman sebelumnya dengan pesan error
        if ($validator->fails()) {
            return back()->with('alert', [
                'type' => 'danger',
                'messages' => $validator->errors()->all(),
            ])->onlyInput();
        }
        // Jika password dan konfirmasi password tidak sama
        if ($request->newPassword !== $request->passwordConfirm) {
            return back()->with('alert', [
                'type' => 'danger',
                'messages' => ['Password dan konfirmasi password tidak sama.'],
            ])->onlyInput('newPassword', 'passwordConfirm');
        }

        $email = session()->get('email');
        // Cari user berdasarkan email
        $user = User::where('email', $email)->first();
        session()->forget('email');

        // Jika user tidak ditemukan
        if (!$user) {
            return back()->with('alert', [
                'type' => 'danger',
                'messages' => ['Email tidak terdaftar.'],
            ])->onlyInput('email');
        }

        // Jika user is_disable
        if ($user->is_disable) {
            return back()->with('alert', [
                'type' => 'danger',
                'messages' => ['Akun Anda dinonaktifkan. Harap hubungi administrator.'],
            ])->onlyInput('email');
        }

        $user->update([
            'password' => Hash::make($request->newPassword),
            'updated_at' => now(),
        ]);

        return redirect()->route('login')->with('alert', [
            'type' => 'success',
            'messages' => ['Password berhasil diubah. Silahkan login.'],
        ]);
    }

    /**
     * Logout pengguna.
     */
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('message', 'Anda telah keluar.');
    }
}
