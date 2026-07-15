<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Kafetani

Aplikasi Laravel untuk kafe sekaligus marketplace hasil tani — pelanggan bisa pesan menu kafe atau beli produk segar langsung dari petani lokal, sementara admin/kasir mengelola pesanan, produk, dan data petani dari satu dashboard.

## Quickstart

**Prasyarat:** PHP 8.3+, Composer, Bun. Database pakai SQLite secara default, jadi tidak wajib install database server terpisah.

```bash
# 1. Install dependency
composer install
bun install

# 2. Siapkan environment
cp .env.example .env        # Windows (PowerShell): copy .env.example .env
php artisan key:generate

# 3. Siapkan database (tabel sessions perlu digenerate manual dulu)
php artisan make:session-table
php artisan migrate --seed  # kalau ditanya bikin file SQLite, pilih "yes"

# 4. Build asset frontend
bun run build

# 5. Jalankan server
php artisan serve
```

Buka **http://127.0.0.1:8000** di browser. `--seed` di atas otomatis mengisi kategori, petani, produk contoh, dan dua akun berikut:

| Role  | Email               | Password     |
|-------|---------------------|--------------|
| Admin | admin@gmail.com     | kafetani2025 |
| Kasir | kasir@kafetani.com  | kasir123     |

**Pakai MySQL?** Ganti baris berikut di `.env` sebelum langkah migrasi:
```env
DB_CONNECTION=mysql
DB_DATABASE=db_kafetani
DB_USERNAME=root
DB_PASSWORD=
```

**Development sehari-hari:** `bun run dev` (bukan `build`) supaya asset auto-reload. Atau jalankan server, queue worker, log viewer, dan Vite sekaligus dengan satu perintah:
```bash
composer run dev
```

## Konfigurasi Production (Domain, Google Sign-In, Midtrans)

Selain langkah Quickstart di atas, deployment production butuh beberapa konfigurasi tambahan di `.env`:

### 1. Domain
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://domain-kamu.com
```
`APP_URL` dipakai oleh helper `asset()`/`asset_v()` untuk generate URL gambar (avatar petani, foto produk, dll) — pastikan ini sudah domain final sebelum deploy, karena beberapa cache Laravel (`view`, `config`) menyimpan hasil generate URL dan perlu di-clear ulang kalau `APP_URL` berubah:
```bash
php artisan config:clear
php artisan view:clear
```

### 2. Google Sign-In
Buat OAuth Client ID di [Google Cloud Console](https://console.cloud.google.com/apis/credentials) (tipe **Web application**), lalu isi:
```env
GOOGLE_CLIENT_ID=xxxxxxxx.apps.googleusercontent.com
GOOGLE_CLIENT_SECRET=xxxxxxxx
GOOGLE_REDIRECT_URI=https://domain-kamu.com/auth/google/callback
```
`GOOGLE_REDIRECT_URI` di atas **harus** didaftarkan persis sama di Google Cloud Console pada bagian *Authorized redirect URIs*, kalau tidak, login Google akan gagal dengan error `redirect_uri_mismatch`.

### 3. Midtrans
Ambil Server Key & Client Key dari [Midtrans Dashboard](https://dashboard.midtrans.com/) (Settings → Access Keys):
```env
MIDTRANS_SERVER_KEY=Mid-server-xxxxxxxx
MIDTRANS_CLIENT_KEY=Mid-client-xxxxxxxx
MIDTRANS_IS_PRODUCTION=true
MIDTRANS_SNAP_URL=https://app.midtrans.com/snap/snap.js
```
- Saat masih testing, biarkan `MIDTRANS_IS_PRODUCTION=false` dan `MIDTRANS_SNAP_URL` mengarah ke `app.sandbox.midtrans.com`, lalu pakai Server/Client Key dari mode **Sandbox** di dashboard (bukan Production) — server key sandbox dan production tidak bisa saling dicampur.
- Di Midtrans Dashboard → **Settings → Configuration**, isi *Payment Notification URL* dengan:
  ```
  https://domain-kamu.com/midtrans/notification
  ```
  Endpoint ini menerima webhook status pembayaran (lihat `app/Http/Controllers/Api/MidtransController.php`); tanpa ini, status pesanan tidak akan otomatis berubah jadi `paid` setelah pelanggan membayar.

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

In addition, [Laracasts](https://laracasts.com) contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

You can also watch bite-sized lessons with real-world projects on [Laravel Learn](https://laravel.com/learn), where you will be guided through building a Laravel application from scratch while learning PHP fundamentals.

## Agentic Development

Laravel's predictable structure and conventions make it ideal for AI coding agents like Claude Code, Cursor, and GitHub Copilot. Install [Laravel Boost](https://laravel.com/docs/ai) to supercharge your AI workflow:

```bash
composer require laravel/boost --dev

php artisan boost:install
```

Boost provides your agent 15+ tools and skills that help agents build Laravel applications while following best practices.

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).