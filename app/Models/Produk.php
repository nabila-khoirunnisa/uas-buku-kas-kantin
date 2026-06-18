<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $fillable = [
        'kios_id',
        'nama_produk',
        'harga_pokok',
        'harga_jual',
        'stok_perhari',
    ];

    public function kios()
    {
        return $this->belongsTo(Kios::class);
    }
}

