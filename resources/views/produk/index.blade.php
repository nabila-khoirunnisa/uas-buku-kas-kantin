@extends('layouts.app')

@section('page-title', 'Produk')

@section('content')

<h2 class="mb-4">Kelola Produk</h2>

<a href="{{ route('produk.create') }}" class="btn btn-primary mb-3">Tambah Produk</a>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>No</th>
            <th>Nama Produk</th>
            <th>Harga Pokok</th>
            <th>Harga Jual</th>
            <th>Stok/Hari</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($produk as $item)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->nama_produk }}</td>
            <td>Rp {{ number_format($item->harga_pokok) }}</td>
            <td>Rp {{ number_format($item->harga_jual) }}</td>
            <td>{{ $item->stok_perhari }}</td>
            <td>
                <a href="{{ route('produk.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                <form action="{{ route('produk.destroy', $item->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm"
                            onclick="return confirm('Yakin hapus produk ini?')">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $produk->links() }}

@endsection