<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Farmer extends Model
{
    protected $fillable = ['user_id', 'name', 'location', 'contact', 'bio', 'avatar'];

    // Tabel tidak pakai updated_at
    const UPDATED_AT = null;

    /**
     * Relasi: satu petani bisa punya banyak produk (foreign key murni: farmer_id)
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'farmer_id');
    }

    /**
     * Relasi: profil farmer ini terhubung ke satu akun user (role: petani).
     * Nullable — farmer lama yang belum onboarding akun tidak punya user_id.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Accessor: URL avatar lengkap
     */
    public function getAvatarUrlAttribute(): string
    {
        return $this->avatar
            ? asset('img/farmers/' . $this->avatar)
            : asset('img/farmers/default.webp');
    }
}
