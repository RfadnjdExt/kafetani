<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Menambahkan role 'petani' ke enum kolom users.role.
 *
 * Role ini digunakan oleh Petani Lokal sebagai aktor sistem penuh (lihat
 * SRS Kafetani v1.1 Bab 2.3 & Bab 6): mereka login dengan akun sendiri,
 * bukan sekadar data pasif yang di-CRUD admin di tabel `farmers`.
 *
 * MySQL/MariaDB tidak mendukung ALTER COLUMN ... ADD VALUE untuk enum
 * secara langsung lewat Schema Builder, jadi kita pakai raw SQL untuk
 * MySQL dan biarkan SQLite (tanpa constraint enum sungguhan) apa adanya.
 */
return new class extends Migration
{
    public function up(): void
    {
        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'mysql') {
            DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'kasir', 'user', 'petani') NOT NULL DEFAULT 'user'");
        }

        // SQLite: kolom enum disimpan sebagai TEXT tanpa CHECK constraint
        // bawaan Laravel di sini, jadi tidak perlu perubahan skema apa pun.
    }

    public function down(): void
    {
        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'mysql') {
            // Pastikan tidak ada user dengan role 'petani' tersisa sebelum
            // mengecilkan kembali enum, supaya rollback tidak gagal.
            DB::table('users')->where('role', 'petani')->update(['role' => 'user']);
            DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'kasir', 'user') NOT NULL DEFAULT 'user'");
        }
    }
};
