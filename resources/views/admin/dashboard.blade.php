@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container">
    <h1 class="mb-4">Dashboard Admin</h1>

    <div class="row">
        <div class="col-md-3">
            <div class="card text-bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Users</h5>
                    <p class="card-text fs-3">{{ $totalUsers }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Books</h5>
                    <p class="card-text fs-3">{{ $totalBooks }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-bg-warning mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Orders</h5>
                    <p class="card-text fs-3">{{ $totalOrders }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-bg-info mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Categories</h5>
                    <p class="card-text fs-3">{{ $totalCategories }}</p>
                </div>
            </div>
        </div>
    </div>

    <p>Selamat datang di halaman dashboard admin BookStore. Gunakan menu navigasi di atas untuk mengelola kategori, buku, user, dan pesanan.</p>
</div>
@endsection