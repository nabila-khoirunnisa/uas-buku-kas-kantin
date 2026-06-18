<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\TransaksiHarian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TransaksiHarianController extends Controller
{
    public function index()
    {
        $transaksi = TransaksiHarian::with('produk')
            ->orderBy('tanggal_transaksi', 'desc')
            ->paginate(15);

        return view('transaksi.index', compact('transaksi'));
    }

    public function create()
    {
        $produk = Produk::orderBy('nama_produk')->get();
        return view('transaksi.create', compact('produk'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal_transaksi' => 'required|date',
            'produk_id'         => 'required|exists:produks,id',
            'jumlah'            => 'required|integer|min:1',
            'bukti'             => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $produk = Produk::find($request->produk_id);
        $total = $produk->harga_jual * $request->jumlah;

        $bukti = null;
        if ($request->hasFile('bukti')) {
            $bukti = $request->file('bukti')->store('bukti_transaksi', 'public');
        }

        TransaksiHarian::create([
            'tanggal_transaksi' => $request->tanggal_transaksi,
            'produk_id'         => $request->produk_id,
            'harga_pokok'       => $produk->harga_pokok,
            'harga_jual'        => $produk->harga_jual,
            'jumlah'            => $request->jumlah,
            'total'             => $total,
            'bukti'             => $bukti,
        ]);

        return redirect()->route('transaksi.index')
            ->with('success', 'Data transaksi berhasil ditambahkan!');
    }

    public function edit(TransaksiHarian $transaksi)
    {
        $produk = Produk::orderBy('nama_produk')->get();
        return view('transaksi.edit', compact('transaksi', 'produk'));
    }

    public function update(Request $request, TransaksiHarian $transaksi)
    {
        $request->validate([
            'tanggal_transaksi' => 'required|date',
            'produk_id'         => 'required|exists:produks,id',
            'jumlah'            => 'required|integer|min:1',
            'bukti'             => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $produk = Produk::find($request->produk_id);
        $total = $produk->harga_jual * $request->jumlah;

        $bukti = $transaksi->bukti;
        if ($request->hasFile('bukti')) {
            if ($transaksi->bukti) {
                Storage::disk('public')->delete($transaksi->bukti);
            }
            $bukti = $request->file('bukti')->store('bukti_transaksi', 'public');
        }

        $transaksi->update([
            'tanggal_transaksi' => $request->tanggal_transaksi,
            'produk_id'         => $request->produk_id,
            'harga_pokok'       => $produk->harga_pokok,
            'harga_jual'        => $produk->harga_jual,
            'jumlah'            => $request->jumlah,
            'total'             => $total,
            'bukti'             => $bukti,
        ]);

        return redirect()->route('transaksi.index')
            ->with('success', 'Data transaksi berhasil diperbarui!');
    }

    public function destroy(TransaksiHarian $transaksi)
    {
        if ($transaksi->bukti) {
            Storage::disk('public')->delete($transaksi->bukti);
        }

        $transaksi->delete();

        return redirect()->route('transaksi.index')
            ->with('success', 'Data transaksi berhasil dihapus!');
    }
}