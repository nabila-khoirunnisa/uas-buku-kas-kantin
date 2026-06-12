<?php

namespace App\Http\Controllers;

use App\Models\Kios;
use App\Models\TransaksiHarian;
use Illuminate\Http\Request;

class TransaksiHarianController extends Controller
{
    public function index()
{
    $transaksi = TransaksiHarian::with('kios')
        ->orderBy('tanggal_transaksi', 'asc')
        ->paginate(15);

    return view('transaksi.index', compact('transaksi'));
}

    public function create()
    {
        $kios = Kios::all();
        
        return view('transaksi.create', compact('kios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal_transaksi' => 'required|date',
            'kios_id' => 'required|exists:kios,id',
            'total_pemasukan'   => 'required|numeric|min:0',
            'total_pengeluaran' => 'required|numeric|min:0',
            'keterangan'        => 'nullable|string',
        ]);

        $kios = Kios::find($request->kios_id);

TransaksiHarian::create([
    'tanggal_transaksi' => $request->tanggal_transaksi,
    'kios_id' => $request->kios_id,
    'total_pemasukan' => $request->total_pemasukan,
    'total_pengeluaran' => $request->total_pengeluaran,
    'keterangan' => $request->keterangan,
]);

        return redirect()->route('transaksi.index')
            ->with('success', 'Data transaksi berhasil ditambahkan!');
    }

    public function edit(TransaksiHarian $transaksi)
{
    $kios = Kios::all();

    return view('transaksi.edit', compact('transaksi', 'kios'));
}

    public function update(Request $request, TransaksiHarian $transaksi)
    {
        $request->validate([
            'tanggal_transaksi' => 'required|date',
            'kios_id' => 'required|exists:kios,id',
            'total_pemasukan'   => 'required|numeric|min:0',
            'total_pengeluaran' => 'required|numeric|min:0',
            'keterangan'        => 'nullable|string',
        ]);

        $kios = Kios::find($request->kios_id);

$transaksi->update([
    'tanggal_transaksi' => $request->tanggal_transaksi,
    'kios_id' => $request->kios_id,
    'total_pemasukan' => $request->total_pemasukan,
    'total_pengeluaran' => $request->total_pengeluaran,
    'keterangan' => $request->keterangan,
]);

        return redirect()->route('transaksi.index')
            ->with('success', 'Data transaksi berhasil diperbarui!');
    }

    public function destroy(TransaksiHarian $transaksi)
    {
        $transaksi->delete();

        return redirect()->route('transaksi.index')
            ->with('success', 'Data transaksi berhasil dihapus!');
    }
}