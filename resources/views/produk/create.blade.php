@extends('layouts.app')

@section('content')

<h2 class="mb-4">Tambah Produk</h2>

@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('produk.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label>Nama Produk</label>
        <input type="text" name="nama_produk" class="form-control" value="{{ old('nama_produk') }}">
    </div>

    <div class="mb-3">
        <label>Harga Pokok</label>
        <input type="number" name="harga_pokok" class="form-control" value="{{ old('harga_pokok') }}">
    </div>

    <div class="mb-3">
        <label>Harga Jual</label>
        <input type="number" name="harga_jual" class="form-control" value="{{ old('harga_jual') }}">
    </div>

    <div class="mb-3">
        <label>Stok Per Hari</label>
        <input type="number" name="stok_perhari" class="form-control" value="{{ old('stok_perhari') }}">
    </div>

    <button type="submit" class="btn btn-success">Simpan</button>
    <a href="{{ route('produk.index') }}" class="btn btn-secondary">Kembali</a>
</form>

@endsection