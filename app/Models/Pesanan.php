<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $primaryKey = 'pesanan_id';

    protected $fillable = [
        'user_id',
        'kode_pesanan',
        'total_harga',
        'alamat_pengiriman',
        'metode_pembayaran',
        'status_pesanan',
        'tanggal_pesanan',
    ];

    protected $casts = [
        'tanggal_pesanan' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function detailPesanans()
    {
        return $this->hasMany(DetailPesanan::class, 'pesanan_id', 'pesanan_id');
    }
}