<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pesanans', function (Blueprint $table) {
            $table->id('pesanan_id');
            $table->foreignId('user_id')->constrained('users', 'user_id');
            $table->string('kode_pesanan')->unique();
            $table->decimal('total_harga', 10, 2);
            $table->text('alamat_pengiriman');
            $table->string('metode_pembayaran');
            $table->enum('status_pesanan', ['pending', 'confirmed', 'shipped', 'delivered', 'cancelled'])->default('pending');
            $table->timestamp('tanggal_pesanan');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pesanans');
    }
};