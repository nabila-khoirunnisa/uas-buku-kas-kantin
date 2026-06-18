<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kios_id')->constrained('kios')->onDelete('cascade');
            $table->string('nama_produk');
            $table->decimal('harga_pokok', 10, 2);
            $table->decimal('harga_jual', 10, 2);
            $table->integer('stok_perhari')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produks');
    }
};