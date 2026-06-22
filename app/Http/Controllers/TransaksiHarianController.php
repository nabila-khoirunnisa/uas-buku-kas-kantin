<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksi;
use App\Models\Produk;
use App\Models\TransaksiHarian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TransaksiHarianController extends Controller
{
    public function index()
    {
        $transaksi = TransaksiHarian::with('details.produk')
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
            'produk_id'         => 'required|array|min:1',
            'produk_id.*'       => 'required|exists:produks,id',
            'jumlah'            => 'required|array|min:1',
            'jumlah.*'          => 'required|integer|min:1',
            'bukti'             => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $bukti = null;
        if ($request->hasFile('bukti')) {
            $bukti = $request->file('bukti')->store('bukti_transaksi', 'public');
        }

        DB::transaction(function () use ($request, $bukti) {
            $total = 0;

            $transaksi = TransaksiHarian::create([
                'tanggal_transaksi' => $request->tanggal_transaksi,
                'total'             => 0,
                'bukti'             => $bukti,
            ]);

            foreach ($request->produk_id as $index => $produk_id) {
                $produk   = Produk::find($produk_id);
                $jumlah   = $request->jumlah[$index];
                $subtotal = $produk->harga_jual * $jumlah;
                $total   += $subtotal;

                DetailTransaksi::create([
                    'transaksi_harian_id' => $transaksi->id,
                    'produk_id'           => $produk_id,
                    'harga_pokok'         => $produk->harga_pokok,
                    'harga_jual'          => $produk->harga_jual,
                    'jumlah'              => $jumlah,
                    'subtotal'            => $subtotal,
                ]);
            }

            $transaksi->update(['total' => $total]);
        });

        return redirect()->route('transaksi.index')
            ->with('success', 'Data transaksi berhasil ditambahkan!');
    }

    public function edit(TransaksiHarian $transaksi)
    {
        $produk = Produk::orderBy('nama_produk')->get();
        $transaksi->load('details.produk');
        return view('transaksi.edit', compact('transaksi', 'produk'));
    }

    public function update(Request $request, TransaksiHarian $transaksi)
    {
        $request->validate([
            'tanggal_transaksi' => 'required|date',
            'produk_id'         => 'required|array|min:1',
            'produk_id.*'       => 'required|exists:produks,id',
            'jumlah'            => 'required|array|min:1',
            'jumlah.*'          => 'required|integer|min:1',
            'bukti'             => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $bukti = $transaksi->bukti;
        if ($request->hasFile('bukti')) {
            if ($transaksi->bukti) {
                Storage::disk('public')->delete($transaksi->bukti);
            }
            $bukti = $request->file('bukti')->store('bukti_transaksi', 'public');
        }

        DB::transaction(function () use ($request, $transaksi, $bukti) {
            $total = 0;

            // hapus detail lama
            $transaksi->details()->delete();

            foreach ($request->produk_id as $index => $produk_id) {
                $produk   = Produk::find($produk_id);
                $jumlah   = $request->jumlah[$index];
                $subtotal = $produk->harga_jual * $jumlah;
                $total   += $subtotal;

                DetailTransaksi::create([
                    'transaksi_harian_id' => $transaksi->id,
                    'produk_id'           => $produk_id,
                    'harga_pokok'         => $produk->harga_pokok,
                    'harga_jual'          => $produk->harga_jual,
                    'jumlah'              => $jumlah,
                    'subtotal'            => $subtotal,
                ]);
            }

            $transaksi->update([
                'tanggal_transaksi' => $request->tanggal_transaksi,
                'total'             => $total,
                'bukti'             => $bukti,
            ]);
        });

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