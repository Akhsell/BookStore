<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Keranjang;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function dashboard()
    {
        $bukus = Buku::with('kategori')->latest()->take(8)->get();
        $kategoris = Kategori::all();
        return view('user.dashboard', compact('bukus', 'kategoris'));
    }

    public function aboutUs()
    {
        return view('user.about');
    }

    public function contact()
    {
        return view('user.contact');
    }

    public function search(Request $request)
    {
        $query = $request->get('q');
        $bukus = Buku::where('judul', 'LIKE', "%{$query}%")
                    ->orWhere('penulis', 'LIKE', "%{$query}%")
                    ->with('kategori')
                    ->paginate(12);
        
        return view('user.search', compact('bukus', 'query'));
    }

    public function addToCart(Request $request, Buku $buku)
    {
        $request->validate([
            'jumlah' => 'required|integer|min:1',
        ]);

        $userId = Auth::id();
        $existingItem = Keranjang::where('user_id', $userId)
                                ->where('buku_id', $buku->buku_id)
                                ->first();

        if ($existingItem) {
            $existingItem->jumlah += $request->jumlah;
            $existingItem->subtotal = $existingItem->jumlah * $buku->harga;
            $existingItem->save();
        } else {
            Keranjang::create([
                'user_id' => $userId,
                'buku_id' => $buku->buku_id,
                'jumlah' => $request->jumlah,
                'subtotal' => $request->jumlah * $buku->harga,
            ]);
        }

        return redirect()->back()->with('success', 'Buku berhasil ditambahkan ke keranjang');
    }

    public function cart()
    {
        $keranjangItems = Keranjang::where('user_id', Auth::id())
                                  ->with('buku')
                                  ->get();
        $total = $keranjangItems->sum('subtotal');
        
        return view('user.cart', compact('keranjangItems', 'total'));
    }

    public function updateCart(Request $request, Keranjang $keranjang)
    {
        $request->validate([
            'jumlah' => 'required|integer|min:1',
        ]);

        $keranjang->jumlah = $request->jumlah;
        $keranjang->subtotal = $keranjang->jumlah * $keranjang->buku->harga;
        $keranjang->save();

        return redirect()->back()->with('success', 'Keranjang berhasil diupdate');
    }

    public function removeFromCart(Keranjang $keranjang)
    {
        $keranjang->delete();
        return redirect()->back()->with('success', 'Item berhasil dihapus dari keranjang');
    }

    public function checkout()
    {
        $keranjangItems = Keranjang::where('user_id', Auth::id())
                                  ->with('buku')
                                  ->get();
        $total = $keranjangItems->sum('subtotal');
        
        return view('user.checkout', compact('keranjangItems', 'total'));
    }

    public function processCheckout(Request $request)
    {
        $request->validate([
            'alamat_pengiriman' => 'required',
            'metode_pembayaran' => 'required',
        ]);

        $userId = Auth::id();
        $keranjangItems = Keranjang::where('user_id', $userId)->with('buku')->get();
        
        if ($keranjangItems->isEmpty()) {
            return redirect()->route('user.cart')->with('error', 'Keranjang kosong');
        }

        $totalHarga = $keranjangItems->sum('subtotal');
        $kodePesanan = 'ORD-' . strtoupper(uniqid());

        // Create Pesanan
        $pesanan = Pesanan::create([
            'user_id' => $userId,
            'kode_pesanan' => $kodePesanan,
            'total_harga' => $totalHarga,
            'alamat_pengiriman' => $request->alamat_pengiriman,
            'metode_pembayaran' => $request->metode_pembayaran,
            'status_pesanan' => 'pending',
            'tanggal_pesanan' => now(),
        ]);

        // Create Detail Pesanan
        foreach ($keranjangItems as $item) {
            DetailPesanan::create([
                'pesanan_id' => $pesanan->pesanan_id,
                'buku_id' => $item->buku_id,
                'jumlah' => $item->jumlah,
                'harga_satuan' => $item->buku->harga,
                'subtotal' => $item->subtotal,
            ]);

            // Update stock
            $item->buku->decrement('stok', $item->jumlah);
        }

        // Clear cart
        Keranjang::where('user_id', $userId)->delete();

        return redirect()->route('user.orders')->with('success', 'Pesanan berhasil dibuat');
    }

    public function orders()
    {
        $pesanans = Pesanan::where('user_id', Auth::id())
                          ->with('detailPesanans.buku')
                          ->latest()
                          ->get();
        
        return view('user.orders', compact('pesanans'));
    }
}