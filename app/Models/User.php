<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'user_id';

    protected $fillable = [
        'username',
        'email',
        'password',
        'full_name',
        'phone',
        'address',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function keranjangs()
    {
        return $this->hasMany(Keranjang::class, 'user_id', 'user_id');
    }

    public function pesanans()
    {
        return $this->hasMany(Pesanan::class, 'user_id', 'user_id');
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}