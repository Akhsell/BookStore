<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Kategori;
use App\Models\Buku;
use App\Models\Pesanan;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers = User::where('role', 'user')->count();
        $totalBooks = Buku::count();
        $totalOrders = Pesanan::count();
        $totalCategories = Kategori::count();

        return view('admin.dashboard', compact('totalUsers', 'totalBooks', 'totalOrders', 'totalCategories'));
    }

    // Kategori Management
    public function kategoris()
    {
        $kategoris = Kategori::all();
        return view('admin.kategoris.index', compact('kategoris'));
    }

    public function createKategori()
    {
        return view('admin.kategoris.create');
    }

    public function storeKategori(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required',
            'deskripsi' => 'required',
        ]);

        Kategori::create($request->all());
        return redirect()->route('admin.kategoris')->with('success', 'Kategori berhasil ditambahkan');
    }

    public function editKategori(Kategori $kategori)
    {
        return view('admin.kategoris.edit', compact('kategori'));
    }

    public function updateKategori(Request $request, Kategori $kategori)
    {
        $request->validate([
            'nama_kategori' => 'required',
            'deskripsi' => 'required',
        ]);

        $kategori->update($request->all());
        return redirect()->route('admin.kategoris')->with('success', 'Kategori berhasil diupdate');
    }

    public function destroyKategori(Kategori $kategori)
    {
        $kategori->delete();
        return redirect()->route('admin.kategoris')->with('success', 'Kategori berhasil dihapus');
    }

    // Buku Management
    public function bukus()
    {
        $bukus = Buku::with('kategori')->get();
        return view('admin.bukus.index', compact('bukus'));
    }

    public function createBuku()
    {
        $kategoris = Kategori::all();
        return view('admin.bukus.create', compact('kategoris'));
    }

    public function storeBuku(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'penulis' => 'required',
            'isbn' => 'required|unique:bukus',
            'deskripsi' => 'required',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'kategori_id' => 'required|exists:kategoris,kategori_id',
        ]);

        Buku::create($request->all());
        return redirect()->route('admin.bukus')->with('success', 'Buku berhasil ditambahkan');
    }

    public function editBuku(Buku $buku)
    {
        $kategoris = Kategori::all();
        return view('admin.bukus.edit', compact('buku', 'kategoris'));
    }

    public function updateBuku(Request $request, Buku $buku)
    {
        $request->validate([
            'judul' => 'required',
            'penulis' => 'required',
            'isbn' => 'required|unique:bukus,isbn,' . $buku->buku_id . ',buku_id',
            'deskripsi' => 'required',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'kategori_id' => 'required|exists:kategoris,kategori_id',
        ]);

        $buku->update($request->all());
        return redirect()->route('admin.bukus')->with('success', 'Buku berhasil diupdate');
    }

    public function destroyBuku(Buku $buku)
    {
        $buku->delete();
        return redirect()->route('admin.bukus')->with('success', 'Buku berhasil dihapus');
    }

    // User Management
    public function users()
    {
        $users = User::where('role', 'user')->get();
        return view('admin.users', compact('users'));
    }

    // Pesanan Management
    public function pesanans()
    {
        $pesanans = Pesanan::with('user', 'detailPesanans.buku')->get();
        return view('admin.pesanans', compact('pesanans'));
    }

    public function updateStatusPesanan(Request $request, Pesanan $pesanan)
    {
        $request->validate([
            'status_pesanan' => 'required|in:pending,confirmed,shipped,delivered,cancelled',
        ]);

        $pesanan->update(['status_pesanan' => $request->status_pesanan]);
        return redirect()->route('admin.pesanans')->with('success', 'Status pesanan berhasil diupdate');
    }
}