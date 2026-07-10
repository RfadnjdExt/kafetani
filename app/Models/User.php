<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public $timestamps = false;

    protected $fillable = ['nama', 'email', 'password', 'role', 'google_id', 'avatar'];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = ['password' => 'hashed'];

    /**
     * Relasi: satu user bisa punya banyak orders
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Relasi: satu user (role: petani) punya satu profil farmer (1:1)
     */
    public function farmer()
    {
        return $this->hasOne(Farmer::class);
    }

    /**
     * Cek apakah user adalah admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Cek apakah user adalah kasir atau admin
     */
    public function isKasirOrAdmin(): bool
    {
        return in_array($this->role, ['admin', 'kasir']);
    }

    /**
     * Cek apakah user adalah petani lokal
     */
    public function isPetani(): bool
    {
        return $this->role === 'petani';
    }
}
