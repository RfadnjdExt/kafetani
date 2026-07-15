<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Kolom terpisah untuk order_id yang dikirim ke Midtrans.
     *
     * Sebelumnya kita mengirim $order->id (primary key) langsung sebagai
     * transaction_details.order_id ke Midtrans. Midtrans mewajibkan order_id
     * unik selamanya untuk satu merchant/server key (bukan cuma unik di DB
     * kita) — begitu tabel orders di-reset/reseed, auto-increment mengulang
     * dari 1 dan bentrok dengan order_id yang sudah pernah dipakai
     * sebelumnya, menyebabkan error "order_id sudah digunakan". Kolom baru
     * ini menyimpan ID unik per percobaan transaksi Midtrans, terpisah dari
     * primary key order.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('midtrans_order_id')->nullable()->unique()->after('id');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('midtrans_order_id');
        });
    }
};
