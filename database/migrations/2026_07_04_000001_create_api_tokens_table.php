<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabel token untuk auth aplikasi Android (native).
     * Polanya mirip Sanctum personal access token, tapi ditulis manual
     * karena package Sanctum tidak terpasang di project ini — cukup
     * dengan fitur bawaan Laravel (Auth::viaRequest), tanpa dependency baru.
     */
    public function up(): void
    {
        Schema::create('api_tokens', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('token', 64)->unique(); // hash SHA-256 dari token asli
            $table->string('device_name', 100)->nullable();
            $table->timestamp('last_used_at')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('api_tokens');
    }
};
