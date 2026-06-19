<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\DetailTransaksi;

class TransaksiHarian extends Model
{
    protected $fillable = [
    'tanggal_transaksi',
    'total',
    'bukti',
];

    
    public function detailTransaksis()
{
    return $this->hasMany(DetailTransaksi::class);
}
}