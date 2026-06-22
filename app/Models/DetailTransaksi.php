<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    protected $fillable = [
        'transaksi_harian_id',
        'produk_id',
        'harga_pokok',
        'harga_jual',
        'jumlah',
        'subtotal',
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }

    public function transaksi()
    {
        return $this->belongsTo(TransaksiHarian::class, 'transaksi_harian_id');
    }
}