<?php

namespace App\Http\Controllers;

use App\Models\TransaksiHarian;
use Illuminate\Http\Request;

class TransaksiHarianController extends Controller
{
    public function index()
    {
        $transaksi = TransaksiHarian::orderBy('tanggal_transaksi', 'asc')->paginate(15);
        return view('transaksi.index', compact('transaksi'));
    }

    public function create()
    {
        return view('transaksi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal_transaksi' => 'required|date',
            'nama_kios'         => 'required|string|max:100',
            'total_pemasukan'   => 'required|numeric|min:0',
            'total_pengeluaran' => 'required|numeric|min:0',
            'keterangan'        => 'nullable|string',
        ]);

        TransaksiHarian::create($request->all());

        return redirect()->route('transaksi.index')
            ->with('success', 'Data transaksi berhasil ditambahkan!');
    }

    public function edit(TransaksiHarian $transaksi)
    {
        return view('transaksi.edit', compact('transaksi'));
    }

    public function update(Request $request, TransaksiHarian $transaksi)
    {
        $request->validate([
            'tanggal_transaksi' => 'required|date',
            'nama_kios'         => 'required|string|max:100',
            'total_pemasukan'   => 'required|numeric|min:0',
            'total_pengeluaran' => 'required|numeric|min:0',
            'keterangan'        => 'nullable|string',
        ]);

        $transaksi->update($request->all());

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