<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class GoogleAuthController extends Controller
{
    protected string $authUrl  = 'https://accounts.google.com/o/oauth2/v2/auth';
    protected string $tokenUrl = 'https://oauth2.googleapis.com/token';
    protected string $userUrl  = 'https://www.googleapis.com/oauth2/v3/userinfo';

    /**
     * Redirect user ke halaman consent Google.
     */
    public function redirect(Request $request)
    {
        $state = Str::random(40);
        $request->session()->put('google_oauth_state', $state);

        $query = http_build_query([
            'client_id'     => config('services.google.client_id'),
            'redirect_uri'  => config('services.google.redirect'),
            'response_type' => 'code',
            'scope'         => 'openid email profile',
            'state'         => $state,
            'prompt'        => 'select_account',
        ]);

        return redirect($this->authUrl . '?' . $query);
    }

    /**
     * Tangani callback dari Google, tukar code -> token -> data user.
     */
    public function callback(Request $request)
    {
        $state = $request->session()->pull('google_oauth_state');

        if (!$request->filled('code') || !$request->filled('state') || $request->state !== $state) {
            return redirect()->route('login')->withErrors([
                'email' => 'Login dengan Google gagal atau dibatalkan. Silakan coba lagi.',
            ]);
        }

        // 1) Tukar authorization code dengan access token
        $tokenResponse = Http::asForm()->post($this->tokenUrl, [
            'client_id'     => config('services.google.client_id'),
            'client_secret' => config('services.google.client_secret'),
            'redirect_uri'  => config('services.google.redirect'),
            'grant_type'    => 'authorization_code',
            'code'          => $request->code,
        ]);

        if ($tokenResponse->failed() || !$tokenResponse->json('access_token')) {
            return redirect()->route('login')->withErrors([
                'email' => 'Gagal terhubung ke Google. Silakan coba lagi.',
            ]);
        }

        $accessToken = $tokenResponse->json('access_token');

        // 2) Ambil data profil user dari Google
        $userResponse = Http::withToken($accessToken)->get($this->userUrl);

        if ($userResponse->failed() || !$userResponse->json('email')) {
            return redirect()->route('login')->withErrors([
                'email' => 'Gagal mengambil data akun Google. Silakan coba lagi.',
            ]);
        }

        $googleUser = $userResponse->json();

        // 3) Cari atau buat user lokal
        $user = User::where('google_id', $googleUser['sub'])
            ->orWhere('email', $googleUser['email'])
            ->first();

        if ($user) {
            if (!$user->google_id) {
                $user->google_id = $googleUser['sub'];
                if (empty($user->avatar) && !empty($googleUser['picture'])) {
                    $user->avatar = $googleUser['picture'];
                }
                $user->save();
            }
        } else {
            $user = User::create([
                'nama'      => $googleUser['name'] ?? $googleUser['email'],
                'email'     => $googleUser['email'],
                'password'  => Hash::make(Str::random(32)),
                'role'      => 'user',
                'google_id' => $googleUser['sub'],
                'avatar'    => $googleUser['picture'] ?? null,
            ]);
        }

        Auth::login($user, true);
        $request->session()->regenerate();

        return redirect()->intended('/');
    }
}
