<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    protected $fillable = [
        'transaksi_harian_id',
        'produk_id',
        'jumlah',
        'harga_jual',
        'subtotal'
    ];

    public function transaksi()
    {
        return $this->belongsTo(TransaksiHarian::class);
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
}