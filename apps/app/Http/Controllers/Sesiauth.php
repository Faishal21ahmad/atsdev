<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\UserOtp;
use App\Mail\SendOtp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;


class Sesiauth extends Controller
{
    /**
     * Tampilkan form login.
     */
    public function showLoginForm()
    {
        $data = [
            'title' => 'Login',
            'test'  => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Tempora, optio!',
        ];
        return view('login', $data);
    }

    /**
     * Proses login.
     */
    public function login(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Email wajib diisi .',
            'email.email' => 'Email tidak valid .',
            'password.required' => 'Password wajib diisi .',
        ]);

        // Coba autentikasi
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Jika akun aktif
            if ($user->is_active) {
                return redirect()->route('dashboard')->with('alert', [
                    'type' => 'success',
                    'messages' => ['Login berhasil! ',' Selamat datang ' . $user->username ],
                ]);
            } else {
                // Jika akun belum aktif, generate OTP melalui Model
                $otp = UserOtp::generateOtp($user->id);

                // Mail::to($user->email)->send(new SendOtp($otp));
                return redirect()->route('otp.form')->with('alert', [
                    'type' => 'alert',
                    'messages' => ['Hai, ' . $user->username . ' Akun mu belum aktif !!','Masukkan OTP yang telah dikirimkan ke email Anda.'],
                ]);
            }
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
    $request->validate([
        'otpfull' => 'required|numeric',
    ], [
        'otpfull.required' => 'Email wajib diisi server.',
        'otpfull.numeric' => 'Email tidak valid server.',
        
    ]);

    // Ambil user yang sedang login
    $user = Auth::user();

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

    // Redirect ke dashboard dengan pesan sukses
    return redirect()->route('dashboard')->with('alert', [
        'type' => 'success',
        'messages' => ['Akun Anda berhasil diaktifkan.'],
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
