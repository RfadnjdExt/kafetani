<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $timestamps = false; // Hanya punya created_at manual di DB

    protected $fillable = [
        'user_id',
        'table_id',
        'midtrans_order_id',
        'total',
        'type',
        'source',
        'customer_name',
        'guest_name',
        'guest_phone',
        'status',
        'snap_token',
        'payment_type',
        'payment_status',
        'transaction_id',
        'paid_at',
    ];

    protected $casts = [
        'total'      => 'integer',
        'created_at' => 'datetime',
        'paid_at'    => 'datetime',
    ];

    /**
     * Relasi: order milik satu user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi: order dari pemesanan mandiri via QR di meja tertentu (nullable
     * — order dari marketplace / kasir tidak terikat meja).
     */
    public function table()
    {
        return $this->belongsTo(Table::class);
    }

    /**
     * Helper: nama pemesan untuk ditampilkan — pakai nama akun kalau order
     * dari user terdaftar, atau nama tamu kalau guest order via QR meja.
     */
    public function getDisplayNameAttribute(): string
    {
        return $this->user?->nama ?? $this->guest_name ?? $this->customer_name ?? 'Tamu';
    }

    /**
     * Relasi: order punya banyak items
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Helper: label status dalam bahasa Indonesia
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending_payment' => 'Menunggu Pembayaran',
            'pending'         => 'Masuk',
            'processing'      => 'Proses',
            'ready'           => 'Siap',
            'completed'       => 'Selesai',
            'cancelled'       => 'Dibatalkan',
            default           => ucfirst($this->status),
        };
    }

    /**
     * Helper: format total ke rupiah
     */
    public function getTotalFormatAttribute(): string
    {
        return 'Rp ' . number_format($this->total, 0, ',', '.');
    }
}
