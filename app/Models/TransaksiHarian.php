<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiHarian extends Model
{
    protected $fillable = [
        'tanggal_transaksi',
        'total',
        'bukti',
    ];

    public function details()
    {
        return $this->hasMany(DetailTransaksi::class, 'transaksi_harian_id');
    }
}