<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    use HasFactory;

    protected $primaryKey = 'keranjang_id';

    protected $fillable = [
        'user_id',
        'buku_id',
        'jumlah',
        'subtotal',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'buku_id', 'buku_id');
    }
}