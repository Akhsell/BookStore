<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('keranjangs', function (Blueprint $table) {
            $table->id('keranjang_id');
            $table->foreignId('user_id')->constrained('users', 'user_id');
            $table->foreignId('buku_id')->constrained('bukus', 'buku_id');
            $table->integer('jumlah');
            $table->decimal('subtotal', 10, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('keranjangs');
    }
};