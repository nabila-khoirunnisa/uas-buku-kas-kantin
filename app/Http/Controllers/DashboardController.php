<?php

namespace App\Http\Controllers;

use App\Models\TransaksiHarian;
use App\Models\DetailTransaksi;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $jumlah_transaksi = TransaksiHarian::count();
        $pendapatan = TransaksiHarian::sum('total');
        $hpp = DetailTransaksi::selectRaw('SUM(harga_pokok * jumlah) as total_hpp')
                    ->value('total_hpp') ?? 0;

        $kas = $pendapatan;
        $keuntungan = $pendapatan - $hpp;

        return view('dashboard', compact(
            'kas',
            'jumlah_transaksi',
            'pendapatan',
            'keuntungan'
        ));
    }
}