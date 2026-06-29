<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ForgotPasswordController extends Controller
{
    /**
     * Tampilkan form lupa password
     */
    public function showForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Kirim email reset password (simulasi — tampilkan token di session)
     * Untuk produksi: gunakan Mailable + SMTP
     */
    public function sendEmail(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email'    => 'Format email tidak valid.',
        ]);

        $user = User::where('email', $request->email)->first();

        // Selalu tampilkan pesan sukses agar tidak bocorkan data email mana yang terdaftar
        if (!$user) {
            return back()->with('status', 'Jika email tersebut terdaftar, link reset password telah dikirim.');
        }

        // Buat token reset
        $token = Str::random(64);

        // Simpan ke tabel password_reset_tokens (Laravel bawaan)
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'email'      => $request->email,
                'token'      => Hash::make($token),
                'created_at' => Carbon::now(),
            ]
        );

        // Simpan token di session untuk dipakai di form reset (tanpa kirim email sungguhan)
        // Pada produksi ganti dengan pengiriman email
        session(['reset_token' => $token, 'reset_email' => $request->email]);

        return redirect()->route('password.reset.form')
                         ->with('status', 'Link reset password telah dikirim. Silakan cek email Anda.')
                         ->with('debug_token', $token); // Hapus baris ini di produksi
    }

    /**
     * Tampilkan form reset password
     */
    public function showResetForm(Request $request)
    {
        $token = $request->query('token') ?? session('reset_token');
        $email = $request->query('email') ?? session('reset_email');

        if (!$token || !$email) {
            return redirect()->route('password.request')
                             ->with('error', 'Link reset tidak valid atau sudah kadaluarsa.');
        }

        return view('auth.reset-password', compact('token', 'email'));
    }

    /**
     * Proses reset password
     */
    public function reset(Request $request)
    {
        $request->validate([
            'email'                => ['required', 'email'],
            'token'                => ['required'],
            'password'             => ['required', 'min:6'],
            'konfirmasi_password'  => ['required', 'same:password'],
        ], [
            'email.required'               => 'Email wajib diisi.',
            'token.required'               => 'Token tidak valid.',
            'password.required'            => 'Password baru wajib diisi.',
            'password.min'                 => 'Password minimal 6 karakter.',
            'konfirmasi_password.required' => 'Konfirmasi password wajib diisi.',
            'konfirmasi_password.same'     => 'Password dan konfirmasi tidak cocok.',
        ]);

        // Cari record token di DB
        $record = DB::table('password_reset_tokens')
                    ->where('email', $request->email)
                    ->first();

        if (!$record || !Hash::check($request->token, $record->token)) {
            return back()->withErrors(['token' => 'Token tidak valid atau sudah kadaluarsa.']);
        }

        // Token expired setelah 60 menit
        if (Carbon::parse($record->created_at)->addMinutes(60)->isPast()) {
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();
            return back()->withErrors(['token' => 'Token sudah kadaluarsa. Minta link baru.']);
        }

        // Update password user
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Email tidak ditemukan.']);
        }

        $user->update(['password' => Hash::make($request->password)]);

        // Hapus token setelah dipakai
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        // Bersihkan session
        session()->forget(['reset_token', 'reset_email']);

        return redirect()->route('login')
                         ->with('status', 'Password berhasil diubah. Silakan login dengan password baru.');
    }
}
