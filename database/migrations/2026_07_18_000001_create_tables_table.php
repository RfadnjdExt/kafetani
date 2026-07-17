<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Tabel "tables" merepresentasikan meja fisik di kafe. Setiap meja punya
// nomor unik yang dipakai sebagai bagian dari URL QR code
// (mis. /meja/12) sehingga pelanggan yang scan QR di meja tersebut
// diarahkan ke halaman menu dengan konteks meja itu.
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tables', function (Blueprint $table) {
            $table->id();
            $table->string('nomor', 20)->unique();
            $table->string('keterangan', 100)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tables');
    }
};
