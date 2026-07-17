<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Mendukung pemesanan mandiri via QR meja (SRS 3.4.1) yang tadinya belum
// diimplementasikan: pelanggan boleh checkout tanpa akun terdaftar
// (guest order) selama scan dari meja yang valid. Karena itu user_id
// perlu jadi nullable, dan kita tambahkan kolom table_id + data tamu.
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->change();
            $table->foreignId('table_id')->nullable()->after('user_id')
                  ->constrained('tables')->nullOnDelete();
            $table->string('guest_name', 100)->nullable()->after('customer_name');
            $table->string('guest_phone', 30)->nullable()->after('guest_name');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropConstrainedForeignId('table_id');
            $table->dropColumn(['guest_name', 'guest_phone']);
            $table->unsignedBigInteger('user_id')->nullable(false)->change();
        });
    }
};
