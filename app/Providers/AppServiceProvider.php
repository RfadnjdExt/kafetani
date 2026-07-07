<?php

namespace App\Providers;

use App\Models\ApiToken;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Konfigurasi Global Midtrans
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        \Midtrans\Config::$isSanitized = config('midtrans.is_sanitized', true);
        \Midtrans\Config::$is3ds = config('midtrans.is_3ds', true);

        // Jika di mode sandbox / local development, abaikan verifikasi SSL
        if (!config('midtrans.is_production')) {
            \Midtrans\Config::$curlOptions = [
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => false,
                // Wajib diisi walau kosong: ApiRequestor.php milik midtrans-php mengakses
                // key ini langsung (bukan lewat isset()), jadi kalau tidak ada, PHP akan
                // melempar "Undefined array key 10023" (10023 = nilai int CURLOPT_HTTPHEADER).
                CURLOPT_HTTPHEADER => [],
            ];
        }

        // Driver auth kustom untuk guard 'api' (dipakai aplikasi Android).
        // Membaca header "Authorization: Bearer <token>", cocokkan hash-nya
        // ke tabel api_tokens, lalu kembalikan User pemilik token tsb.
        Auth::viaRequest('api-token', function ($request) {
            $plain = $request->bearerToken();

            if (! $plain) {
                return null;
            }

            $token = ApiToken::with('user')
                ->where('token', hash('sha256', $plain))
                ->first();

            if (! $token) {
                return null;
            }

            $token->forceFill(['last_used_at' => now()])->save();

            return $token->user;
        });
    }
}
