<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kios extends Model
{
    protected $table = 'kios';

    protected $fillable = [
        'nama_kios',
        'nama_pemilik',
        'jenis_dagangan'
    ];

    public function transaksiHarian()
{
    return $this->hasMany(TransaksiHarian::class);
}
    
    public function produks()
{
    return $this->hasMany(Produk::class);
}
}