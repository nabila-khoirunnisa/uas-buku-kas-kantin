<?php

namespace App\Http\Controllers;

use App\Models\Kios;
use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index()
    {
        $produk = Produk::orderBy('nama_produk')->paginate(15);
        return view('produk.index', compact('produk'));
    }

    public function create()
    {
        return view('produk.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_produk'  => 'required|string|max:255',
            'harga_pokok'  => 'required|numeric|min:0',
            'harga_jual'   => 'required|numeric|min:0',
            'stok_perhari' => 'required|integer|min:0',
        ]);

        $kios = Kios::first();

        Produk::create([
            'kios_id'      => $kios->id,
            'nama_produk'  => $request->nama_produk,
            'harga_pokok'  => $request->harga_pokok,
            'harga_jual'   => $request->harga_jual,
            'stok_perhari' => $request->stok_perhari,
        ]);

        return redirect()->route('produk.index')
            ->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit(Produk $produk)
    {
        return view('produk.edit', compact('produk'));
    }

    public function update(Request $request, Produk $produk)
    {
        $request->validate([
            'nama_produk'  => 'required|string|max:255',
            'harga_pokok'  => 'required|numeric|min:0',
            'harga_jual'   => 'required|numeric|min:0',
            'stok_perhari' => 'required|integer|min:0',
        ]);

        $produk->update([
            'nama_produk'  => $request->nama_produk,
            'harga_pokok'  => $request->harga_pokok,
            'harga_jual'   => $request->harga_jual,
            'stok_perhari' => $request->stok_perhari,
        ]);

        return redirect()->route('produk.index')
            ->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy(Produk $produk)
    {
        $produk->delete();

        return redirect()->route('produk.index')
            ->with('success', 'Produk berhasil dihapus!');
    }
}