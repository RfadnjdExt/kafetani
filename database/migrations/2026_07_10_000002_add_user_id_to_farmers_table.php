<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Menghubungkan 1 akun users(role: petani) ke 1 profil farmers.
 *
 * Nullable karena farmer lama (yang belum onboarding akun/masih dikelola
 * manual oleh admin) tetap valid tanpa user_id. Unique karena relasinya
 * 1:1 — satu akun petani hanya boleh terhubung ke satu profil farmer.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('farmers', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->unique()->after('id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('farmers', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
