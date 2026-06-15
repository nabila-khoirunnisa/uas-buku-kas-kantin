<?php

namespace App\Models;

use App\Models\Kios;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiHarian extends Model
{

    protected $table = 'transaksi_harians';

    protected $fillable = [
    'tanggal_transaksi',
    'kios_id',
    'total_pemasukan',
    'total_pengeluaran',
    'keterangan',
    'bukti',
];
public function kios()
{
    return $this->belongsTo(Kios::class);
}

}