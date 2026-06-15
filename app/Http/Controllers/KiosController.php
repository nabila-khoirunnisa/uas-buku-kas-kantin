<?php

namespace App\Http\Controllers;

use App\Models\Kios;
use Illuminate\Http\Request;

class KiosController extends Controller
{
    public function index()
    {
        $kios = Kios::latest()->get();

        return view('kios.index', compact('kios'));
    }

    public function create()
    {
        return view('kios.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kios' => 'required|string|max:100',
            'nama_pemilik' => 'required|string|max:100',
            'jenis_dagangan' => 'required|string|max:100',
        ]);

        Kios::create($request->all());

        return redirect()->route('kios.index')
            ->with('success', 'Data kios berhasil ditambahkan!');
    }

    public function edit(Kios $kio)
{
    return view('kios.edit', [
        'kios' => $kio
    ]);
}

public function update(Request $request, Kios $kio)
{
    $request->validate([
        'nama_kios' => 'required|string|max:100',
        'nama_pemilik' => 'required|string|max:100',
        'jenis_dagangan' => 'required|string|max:100',
    ]);

    $kio->update($request->all());

    return redirect()->route('kios.index')
        ->with('success', 'Data kios berhasil diperbarui!');
}

public function destroy(Kios $kio)
{
    $kio->delete();

    return redirect()->route('kios.index')
        ->with('success', 'Data kios berhasil dihapus!');
}}