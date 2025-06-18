@extends('layouts.app')

@section('title', 'User Dashboard')

@section('content')
<div class="container">
    <h1 class="mb-4">Dashboard User</h1>

    <h3>Daftar Buku Terbaru</h3>
    <div class="row">
        @forelse($bukus as $buku)
            <div class="col-md-3 mb-4">
                <div class="card h-100">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $buku->judul }}</h5>
                        <p class="card-text text-muted mb-1">Penulis: {{ $buku->penulis }}</p>
                        <p class="card-text mb-1">Kategori: {{ $buku->kategori->nama_kategori ?? '-' }}</p>
                        <p class="card-text fw-bold mb-3">Harga: Rp {{ number_format($buku->harga, 0, ',', '.') }}</p>
                        <a href="{{ route('user.cart.add', $buku->buku_id) }}" class="btn btn-primary mt-auto">Tambah ke Keranjang</a>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-muted">Belum ada buku tersedia.</p>
        @endforelse
    </div>

    <h3>Kategori Buku</h3>
    <ul class="list-group mb-4">
        @forelse($kategoris as $kategori)
            <li class="list-group-item">{{ $kategori->nama_kategori }}</li>
        @empty
            <li class="list-group-item text-muted">Belum ada kategori tersedia.</li>
        @endforelse
    </ul>
</div>
@endsection