<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\ApiToken;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    /**
     * POST /api/register
     * Sama seperti RegisterController versi web, tapi balikin token
     * alih-alih redirect + sesi.
     */
    public function register(Request $request): JsonResponse
    {
        $data = $request->validate([
            'nama_lengkap'         => ['required', 'string', 'max:100'],
            'email'                => ['required', 'email', 'max:100', 'unique:users,email'],
            'password'             => ['required', Password::min(6)],
            'konfirmasi_password'  => ['required', 'same:password'],
            'device_name'          => ['nullable', 'string', 'max:100'],
        ], [
            'nama_lengkap.required'        => 'Nama lengkap wajib diisi.',
            'email.required'               => 'Email wajib diisi.',
            'email.email'                  => 'Format email tidak valid.',
            'email.unique'                 => 'Email sudah terdaftar. Gunakan email lain.',
            'password.required'            => 'Password wajib diisi.',
            'password.min'                 => 'Password minimal 6 karakter.',
            'konfirmasi_password.required' => 'Konfirmasi password wajib diisi.',
            'konfirmasi_password.same'     => 'Password dan konfirmasi password tidak cocok.',
        ]);

        $user = User::create([
            'nama'     => $data['nama_lengkap'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'role'     => 'user',
        ]);

        $token = ApiToken::issueFor($user, $data['device_name'] ?? null);

        return response()->json([
            'success' => true,
            'message' => 'Registrasi berhasil.',
            'token'   => $token,
            'user'    => new UserResource($user),
        ], 201);
    }

    /**
     * POST /api/login
     */
    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email'       => ['required', 'email'],
            'password'    => ['required'],
            'device_name' => ['nullable', 'string', 'max:100'],
        ], [
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau password salah.',
                'errors'  => ['email' => ['Email atau password salah.']],
            ], 422);
        }

        $token = ApiToken::issueFor($user, $credentials['device_name'] ?? null);

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil.',
            'token'   => $token,
            'user'    => new UserResource($user),
        ]);
    }

    /**
     * POST /api/logout
     * Hapus token yang sedang dipakai (device ini saja, device lain tetap login).
     */
    public function logout(Request $request): JsonResponse
    {
        $plain = $request->bearerToken();

        if ($plain) {
            ApiToken::where('token', hash('sha256', $plain))->delete();
        }

        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil.',
        ]);
    }

    /**
     * GET /api/me
     * Dipanggil saat app dibuka, buat cek token yang tersimpan masih valid + ambil data user terbaru.
     */
    public function me(Request $request): JsonResponse
    {
        return response()->json([
            'success' => true,
            'user'    => new UserResource(auth('api')->user()),
        ]);
    }
}
