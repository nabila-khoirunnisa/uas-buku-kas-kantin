<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiHarian extends Model
{
    protected $fillable = [
        'tanggal_transaksi',
        'produk_id',
        'harga_pokok',
        'harga_jual',
        'jumlah',
        'total',
        'bukti',
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
}