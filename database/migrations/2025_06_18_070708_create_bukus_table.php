<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('bukus', function (Blueprint $table) {
            $table->id('buku_id');
            $table->string('judul');
            $table->string('penulis');
            $table->string('isbn');
            $table->text('deskripsi');
            $table->decimal('harga', 10, 2);
            $table->integer('stok');
            $table->string('gambar_url')->nullable();
            $table->foreignId('kategori_id')->constrained('kategoris', 'kategori_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bukus');
    }
};