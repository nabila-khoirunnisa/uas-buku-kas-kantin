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
        $transaksi = TransaksiHarian::with('detailTransaksis.produk')
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
            'produk_id' => 'required|array',
            'produk_id.*' => 'exists:produks,id',
            'jumlah' => 'required|array',
            'jumlah.*' => 'integer|min:1',
            'bukti' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // upload bukti
        $bukti = null;
        if ($request->hasFile('bukti')) {
            $bukti = $request->file('bukti')->store('bukti_transaksi', 'public');
        }

        // hitung total transaksi
        $total = 0;

        foreach ($request->produk_id as $i => $produk_id) {
            $produk = Produk::find($produk_id);
            $total += $produk->harga_jual * $request->jumlah[$i];
        }

        // simpan transaksi utama
        $transaksi = TransaksiHarian::create([
            'tanggal_transaksi' => $request->tanggal_transaksi,
            'total' => $total,
            'bukti' => $bukti,
        ]);

        // simpan detail transaksi
        foreach ($request->produk_id as $i => $produk_id) {
            $produk = Produk::find($produk_id);

            $transaksi->detailTransaksis()->create([
                'produk_id' => $produk_id,
                'jumlah' => $request->jumlah[$i],
                'harga_jual' => $produk->harga_jual,
                'subtotal' => $produk->harga_jual * $request->jumlah[$i],
            ]);
        }

        return redirect()->route('transaksi.index')
            ->with('success', 'Data transaksi berhasil ditambahkan!');
    }

    public function edit(TransaksiHarian $transaksi)
    {
        $produk = Produk::orderBy('nama_produk')->get();
        $transaksi->load('detailTransaksis');

        return view('transaksi.edit', compact('transaksi', 'produk'));
    }

    public function update(Request $request, TransaksiHarian $transaksi)
    {
        $request->validate([
            'tanggal_transaksi' => 'required|date',
            'produk_id' => 'required|array',
            'produk_id.*' => 'exists:produks,id',
            'jumlah' => 'required|array',
            'jumlah.*' => 'integer|min:1',
            'bukti' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // update bukti
        $bukti = $transaksi->bukti;
        if ($request->hasFile('bukti')) {
            if ($transaksi->bukti) {
                Storage::disk('public')->delete($transaksi->bukti);
            }
            $bukti = $request->file('bukti')->store('bukti_transaksi', 'public');
        }

        // hitung ulang total
        $total = 0;
        foreach ($request->produk_id as $i => $produk_id) {
            $produk = Produk::find($produk_id);
            $total += $produk->harga_jual * $request->jumlah[$i];
        }

        // update transaksi utama
        $transaksi->update([
            'tanggal_transaksi' => $request->tanggal_transaksi,
            'total' => $total,
            'bukti' => $bukti,
        ]);

        // hapus detail lama
        $transaksi->detailTransaksis()->delete();

        // insert ulang detail
        foreach ($request->produk_id as $i => $produk_id) {
            $produk = Produk::find($produk_id);

            $transaksi->detailTransaksis()->create([
                'produk_id' => $produk_id,
                'jumlah' => $request->jumlah[$i],
                'harga_jual' => $produk->harga_jual,
                'subtotal' => $produk->harga_jual * $request->jumlah[$i],
            ]);
        }

        return redirect()->route('transaksi.index')
            ->with('success', 'Data transaksi berhasil diperbarui!');
    }

    public function destroy(TransaksiHarian $transaksi)
    {
        if ($transaksi->bukti) {
            Storage::disk('public')->delete($transaksi->bukti);
        }

        $transaksi->detailTransaksis()->delete();
        $transaksi->delete();

        return redirect()->route('transaksi.index')
            ->with('success', 'Data transaksi berhasil dihapus!');
    }
}