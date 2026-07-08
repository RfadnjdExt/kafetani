<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Normalisasi relasi petani–produk.
 *
 * Sebelumnya kolom `product.petani` adalah teks bebas (mis. "Pak Budi - Gayo,
 * Aceh") yang diisi manual dan sama sekali tidak terhubung ke tabel `farmers`
 * — relasi Farmer::products() (hasMany(Product::class, 'petani')) pun tidak
 * pernah benar-benar match apa pun secara data.
 *
 * Migration ini menggantinya dengan foreign key murni `product.farmer_id`
 * yang menunjuk ke `farmers.id`.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('product', function (Blueprint $table) {
            $table->unsignedBigInteger('farmer_id')->nullable()->after('petani');
            $table->foreign('farmer_id')->references('id')->on('farmers')->onDelete('set null');
        });

        // Migrasi data lama: cocokkan teks 'petani' ("Nama - Lokasi") ke
        // farmers.name secara best-effort supaya data existing tidak hilang.
        $farmers = DB::table('farmers')->get(['id', 'name']);

        DB::table('product')->whereNotNull('petani')->orderBy('id_product')->get(['id_product', 'petani'])
            ->each(function ($product) use ($farmers) {
                $namaPetani = trim(explode(' - ', $product->petani)[0]);

                $match = $farmers->first(fn ($f) => strcasecmp($f->name, $namaPetani) === 0);

                if ($match) {
                    DB::table('product')
                        ->where('id_product', $product->id_product)
                        ->update(['farmer_id' => $match->id]);
                }
            });

        Schema::table('product', function (Blueprint $table) {
            $table->dropColumn('petani');
        });
    }

    public function down(): void
    {
        Schema::table('product', function (Blueprint $table) {
            $table->string('petani', 100)->nullable()->after('farmer_id');
        });

        // Kembalikan teks 'petani' dari relasi farmer (best-effort, format disederhanakan).
        DB::table('product')->whereNotNull('farmer_id')->get(['id_product', 'farmer_id'])
            ->each(function ($product) {
                $farmer = DB::table('farmers')->find($product->farmer_id);
                if ($farmer) {
                    DB::table('product')
                        ->where('id_product', $product->id_product)
                        ->update(['petani' => $farmer->name . ' - ' . $farmer->location]);
                }
            });

        Schema::table('product', function (Blueprint $table) {
            $table->dropForeign(['farmer_id']);
            $table->dropColumn('farmer_id');
        });
    }
};
