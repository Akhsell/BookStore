<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('detail_pesanans', function (Blueprint $table) {
            $table->id('detail_id');
            $table->foreignId('pesanan_id')->constrained('pesanans', 'pesanan_id');
            $table->foreignId('buku_id')->constrained('bukus', 'buku_id');
            $table->integer('jumlah');
            $table->decimal('harga_satuan', 10, 2);
            $table->decimal('subtotal', 10, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('detail_pesanans');
    }
};