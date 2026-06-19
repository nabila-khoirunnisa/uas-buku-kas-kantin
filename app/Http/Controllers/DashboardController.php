<?php

namespace App\Http\Controllers;

use App\Models\TransaksiHarian;
use App\Models\Produk;
use App\Models\DetailTransaksi;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $jumlah_transaksi = TransaksiHarian::count();

        $pendapatan = TransaksiHarian::sum('total');

        $hpp = 0;

        $detailTransaksi = DetailTransaksi::with('produk')->get();

        foreach ($detailTransaksi as $detail) {
            if ($detail->produk) {
                $hpp += $detail->produk->harga_pokok * $detail->jumlah;
            }
        }

        $kas = $pendapatan;
        $laba = $pendapatan - $hpp;
        $keuntungan = $laba;

        $produk = Produk::orderBy('nama_produk')->get();

        return view('dashboard', compact(
            'kas',
            'jumlah_transaksi',
            'pendapatan',
            'hpp',
            'laba',
            'keuntungan',
            'produk'
        ));
    }
}