@extends('layouts.app')

@section('content')

<h2 class="mb-4">Data Transaksi Harian</h2>

<a href="{{ route('transaksi.create') }}" class="btn btn-primary mb-3">
    + Tambah Transaksi
</a>

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<table class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
<th>Tanggal</th>
<th>Detail Produk</th>
<th>Total</th>
<th>Bukti</th>

@if(auth()->user()->role === 'admin')
    <th>Aksi</th>
@endif
        </tr>
    </thead>

    <tbody>
        @foreach ($transaksi as $i => $t)
        <tr>
            <td>{{ $transaksi->firstItem() + $i }}</td>

            <td>{{ $t->tanggal_transaksi }}</td>

            <td>
                @foreach ($t->detailTransaksis as $detail)
                    • {{ $detail->produk->nama_produk }} 
                    ({{ $detail->jumlah }} x {{ number_format($detail->harga_jual) }}) 
                    = <b>{{ number_format($detail->subtotal) }}</b>
                    <br>
                @endforeach
            </td>

            <td>
                <b>Rp {{ number_format($t->total) }}</b>
            </td>

            <td>
                @if ($t->bukti)
                    <a href="{{ asset('storage/'.$t->bukti) }}" target="_blank"
   class="btn btn-success btn-sm">
   📄 Lihat Bukti
</a>
                @else
                    -
                @endif
            </td>

            @if(auth()->user()->role === 'admin')
<td>
    <form action="{{ route('transaksi.destroy', $t->id) }}"
          method="POST"
          class="d-inline">

        @csrf
        @method('DELETE')

        <button type="submit"
                class="btn btn-danger btn-sm"
                onclick="return confirm('Yakin ingin menghapus transaksi ini?')">
            🗑 Hapus
        </button>
    </form>
</td>
@endif

        </tr>
        @endforeach
    </tbody>
</table>

<div class="mt-3">
    {{ $transaksi->links() }}
</div>

@endsection