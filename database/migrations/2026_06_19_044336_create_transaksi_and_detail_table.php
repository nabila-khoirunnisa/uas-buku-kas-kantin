<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksi_harians', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_transaksi');
            $table->decimal('total', 10, 2)->default(0);
            $table->string('bukti')->nullable();
            $table->timestamps();
        });

        Schema::create('detail_transaksis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaksi_harian_id')->constrained('transaksi_harians')->onDelete('cascade');
            $table->foreignId('produk_id')->constrained('produks')->onDelete('cascade');
            $table->decimal('harga_pokok', 10, 2);
            $table->decimal('harga_jual', 10, 2);
            $table->integer('jumlah');
            $table->decimal('subtotal', 10, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_transaksis');
        Schema::dropIfExists('transaksi_harians');
    }
};