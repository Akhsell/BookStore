<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    protected $primaryKey = 'buku_id';

    protected $fillable = [
        'judul',
        'penulis',
        'isbn',
        'deskripsi',
        'harga',
        'stok',
        'gambar_url',
        'kategori_id',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id', 'kategori_id');
    }

    public function keranjangs()
    {
        return $this->hasMany(Keranjang::class, 'buku_id', 'buku_id');
    }

    public function detailPesanans()
    {
        return $this->hasMany(DetailPesanan::class, 'buku_id', 'buku_id');
    }
}