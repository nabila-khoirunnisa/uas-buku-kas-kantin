@extends('layouts.app')

@section('content')

<h2 class="mb-4">Data Transaksi Kantin</h2>

<a href="{{ route('transaksi.create') }}" class="btn btn-primary mb-3">
    Tambah Data
</a>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Nama Kios</th>
            <th>Pemasukan</th>
            <th>Pengeluaran</th>
            <th>Catatan</th>
            <th>Aksi</th>
        </tr>
    </thead>

    <tbody>
        @foreach($transaksi as $item)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->tanggal_transaksi }}</td>
            <td>{{ $item->kios->nama_kios ?? '-' }}</td>
            <td>Rp {{ number_format($item->total_pemasukan) }}</td>
            <td>Rp {{ number_format($item->total_pengeluaran) }}</td>
            <td>{{ $item->keterangan }}</td>

            <td>
                <a href="{{ route('transaksi.edit', $item->id) }}"
                   class="btn btn-warning btn-sm">
                    Edit
                </a>

                <form action="{{ route('transaksi.destroy', $item->id) }}"
                      method="POST"
                      class="d-inline">

                    @csrf
                    @method('DELETE')

                    <button type="submit"
                            class="btn btn-danger btn-sm"
                            onclick="return confirm('Yakin hapus data?')">
                        Hapus
                    </button>

                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection