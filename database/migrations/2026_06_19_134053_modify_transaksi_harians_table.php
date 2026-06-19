<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transaksi_harians', function (Blueprint $table) {

            $table->dropForeign(['produk_id']);

            $table->dropColumn([
                'produk_id',
                'harga_pokok',
                'harga_jual',
                'jumlah'
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('transaksi_harians', function (Blueprint $table) {

            $table->foreignId('produk_id')
                  ->constrained('produks')
                  ->cascadeOnDelete();

            $table->decimal('harga_pokok',10,2);
            $table->decimal('harga_jual',10,2);
            $table->integer('jumlah');
        });
    }
};