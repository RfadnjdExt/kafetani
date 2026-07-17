<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    protected $table = 'tables';

    protected $fillable = [
        'nomor',
        'keterangan',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Relasi: satu meja punya banyak pesanan (dari pemesanan mandiri via QR).
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
