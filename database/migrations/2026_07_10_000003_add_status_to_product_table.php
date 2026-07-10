<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Menambahkan alur approval untuk produk marketplace milik petani (FR-19 & FR-23).
 *
 * Hanya relevan untuk product.type = 'market' dengan farmer_id terisi:
 * - 'pending'  → baru didaftarkan/diedit petani, menunggu review admin.
 * - 'approved' → sudah disetujui admin, tampil di Marketplace publik.
 * - 'rejected' → ditolak admin, tidak tampil di Marketplace.
 *
 * Produk yang diinput/diubah langsung oleh admin (termasuk produk cafe,
 * yang tidak melalui alur approval sama sekali) memakai status 'approved'
 * secara otomatis — lihat Admin\ProductController@save.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('product', function (Blueprint $table) {
            $table->enum('status', ['pending', 'approved', 'rejected'])
                  ->default('pending')
                  ->after('type');
        });

        // Backfill: seluruh produk yang sudah ada sebelum migration ini
        // dianggap sudah "disetujui" (baik cafe maupun market lama), supaya
        // tidak tiba-tiba hilang dari Menu Kafe / Marketplace yang sudah
        // berjalan.
        DB::table('product')->update(['status' => 'approved']);
    }

    public function down(): void
    {
        Schema::table('product', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
