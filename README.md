# Kafetani — Farm to Table Cafe & Marketplace

Kafetani adalah website PHP native + MySQL untuk cafe, marketplace petani lokal, dan panel admin sederhana.

## Ringkasan

- Beranda dengan hero, pilihan unggulan, dan halaman informasi.
- Menu kafe untuk produk minuman, bakeri, dan camilan.
- Marketplace petani untuk produk bahan segar dan kebutuhan rumah tangga.
- Autentikasi login dan register.
- Panel admin untuk dashboard, produk, pesanan, dan kasir.
- Skrip utilitas database dan reset akun admin.

## Setup & Instalasi

1. Jalankan Apache dan MySQL melalui XAMPP, Laragon, atau stack lokal lain.
2. Buat database baru dengan nama `db_kafetani`.
3. Import file `config/db_schema.sql` ke database tersebut.
4. Sesuaikan kredensial database di `config/db.php`.
5. Jika halaman lama masih memakai koneksi mysqli, samakan juga isi `config/koneksi.php`.
6. Buka aplikasi di `http://localhost/kafetani/`.

## Akses Cepat

- Beranda: `index.php`
- Menu kafe: `menu.php`
- Marketplace: `marketplace.php`
- Login: `auth/login.php`
- Register: `auth/register.php`
- Dashboard admin: `admin/dashboard.php`
- Kasir admin: `admin/kasir.php`

## Akun Default

- Admin default ada di data schema dengan email `admin@gmail.com`.
- Password awal adalah `admin123`.
- Jika perlu menyetel ulang akun admin, gunakan `reset_admin.php`.

## Fitur

- Autentikasi pengguna dengan alur login dan register.
- Tampilan frontend terpisah untuk beranda, menu, dan marketplace.
- Dashboard admin dengan statistik ringkas.
- Manajemen produk, pesanan, dan kasir di panel admin.
- Endpoint API untuk kebutuhan data frontend.
- Utilitas database seperti `alter_db.php` dan `get_tables.php`.

## Struktur Folder

- `admin/`: halaman panel admin.
- `api/`: endpoint data produk dan pesanan.
- `assets/css/`: stylesheet halaman publik dan admin.
- `assets/js/`: logika frontend untuk dashboard, menu, dan produk.
- `assets/img/`: aset gambar aplikasi.
- `auth/`: login, register, logout, dan proses autentikasi.
- `config/`: koneksi database dan schema.
- `includes/`: komponen layout bersama.
- `marketplace.php`, `menu.php`, `index.php`: halaman utama aplikasi.
- `reset_admin.php`, `alter_db.php`, `get_tables.php`: skrip utilitas.

## Catatan

- Proyek ini masih memakai PHP native tanpa framework.
- Beberapa file utilitas dan koneksi lama dipertahankan untuk kebutuhan migrasi dan maintenance.

---
*Dikembangkan untuk mendukung petani lokal Indonesia.*
