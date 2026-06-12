<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transaksi_harians', function (Blueprint $table) {
            $table->foreignId('kios_id')
                  ->nullable()
                  ->constrained('kios')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('transaksi_harians', function (Blueprint $table) {
            $table->dropForeign(['kios_id']);
            $table->dropColumn('kios_id');
        });
    }
};