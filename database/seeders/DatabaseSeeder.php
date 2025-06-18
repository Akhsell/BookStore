<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Kategori;
use App\Models\Buku;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Create Admin User
        User::create([
            'username' => 'admin',
            'email' => 'admin@bookstore.com',
            'password' => Hash::make('password'),
            'full_name' => 'Administrator',
            'phone' => '081234567890',
            'address' => 'Jakarta',
            'role' => 'admin',
        ]);

        // Create Sample User
        User::create([
            'username' => 'user1',
            'email' => 'user@bookstore.com',
            'password' => Hash::make('password'),
            'full_name' => 'John Doe',
            'phone' => '081987654321',
            'address' => 'Bandung',
            'role' => 'user',
        ]);

        // Create Categories
        $categories = [
            ['nama_kategori' => 'Fiction', 'deskripsi' => 'Buku-buku fiksi dan novel'],
            ['nama_kategori' => 'Non-Fiction', 'deskripsi' => 'Buku-buku non-fiksi dan ensiklopedia'],
            ['nama_kategori' => 'Technology', 'deskripsi' => 'Buku-buku tentang teknologi dan programming'],
            ['nama_kategori' => 'History', 'deskripsi' => 'Buku-buku sejarah'],
            ['nama_kategori' => 'Science', 'deskripsi' => 'Buku-buku sains dan penelitian'],
        ];

        foreach ($categories as $category) {
            Kategori::create($category);
        }

        // Create Sample Books
        $books = [
            [
                'judul' => 'The Great Gatsby',
                'penulis' => 'F. Scott Fitzgerald',
                'isbn' => '978-0-7432-7356-5',
                'deskripsi' => 'A classic American novel set in the Jazz Age',
                'harga' => 125000,
                'stok' => 50,
                'kategori_id' => 1,
            ],
            [
                'judul' => 'Clean Code',
                'penulis' => 'Robert C. Martin',
                'isbn' => '978-0-13-235088-4',
                'deskripsi' => 'A handbook of agile software craftsmanship',
                'harga' => 200000,
                'stok' => 30,
                'kategori_id' => 3,
            ],
            [
                'judul' => 'Sapiens',
                'penulis' => 'Yuval Noah Harari',
                'isbn' => '978-0-06-231609-7',
                'deskripsi' => 'A brief history of humankind',
                'harga' => 180000,
                'stok' => 25,
                'kategori_id' => 4,
            ],
            [
                'judul' => 'The Alchemist',
                'penulis' => 'Paulo Coelho',
                'isbn' => '978-0-06-112241-5',
                'deskripsi' => 'A philosophical novel about following your dreams',
                'harga' => 150000,
                'stok' => 40,
                'kategori_id' => 1,
            ],
            [
                'judul' => 'A Brief History of Time',
                'penulis' => 'Stephen Hawking',
                'isbn' => '978-0-553-38016-3',
                'deskripsi' => 'From the Big Bang to Black Holes',
                'harga' => 175000,
                'stok' => 20,
                'kategori_id' => 5,
            ],
        ];

        foreach ($books as $book) {
            Buku::create($book);
        }
    }
}