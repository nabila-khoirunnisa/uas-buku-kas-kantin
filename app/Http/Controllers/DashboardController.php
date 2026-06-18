<?php

namespace App\Http\Controllers;

use App\Models\TransaksiHarian;
use App\Models\Produk;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $jumlah_transaksi = TransaksiHarian::count();
        $pendapatan = TransaksiHarian::sum('total');
        $hpp = TransaksiHarian::selectRaw('SUM(harga_pokok * jumlah) as total_hpp')
                    ->value('total_hpp') ?? 0;

        $kas = $pendapatan;
        $laba = $pendapatan - $hpp;
        $keuntungan = $laba;

        // ambil data produk
        $produk = Produk::orderBy('nama_produk')->get();

        return view('dashboard', compact(
            'kas',
            'jumlah_transaksi',
            'pendapatan',
            'laba',
            'keuntungan',
            'produk'
        ));
    }
}