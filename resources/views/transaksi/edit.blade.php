@extends('layouts.app')

@section('content')

<h2 class="mb-4">Edit Transaksi</h2>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('transaksi.update', $transaksi->id) }}" method="POST" enctype="multipart/form-data">

    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Tanggal Transaksi</label>
        <input type="date"
               name="tanggal_transaksi"
               class="form-control"
               value="{{ old('tanggal_transaksi', $transaksi->tanggal_transaksi) }}">
    </div>

    <div class="mb-3">
        <label>Nama Kios</label>
        <select name="kios_id" class="form-control">

            @foreach($kios as $item)
                <option value="{{ $item->id }}"
                    {{ $transaksi->kios_id == $item->id ? 'selected' : '' }}>
                    {{ $item->nama_kios }}
                </option>
            @endforeach

        </select>
    </div>

    <div class="mb-3">
        <label>Total Pemasukan</label>
        <input type="number"
               name="total_pemasukan"
               class="form-control"
               value="{{ old('total_pemasukan', $transaksi->total_pemasukan) }}">
    </div>

    <div class="mb-3">
        <label>Total Pengeluaran</label>
        <input type="number"
               name="total_pengeluaran"
               class="form-control"
               value="{{ old('total_pengeluaran', $transaksi->total_pengeluaran) }}">
    </div>

    <div class="mb-3">
        <label>Keterangan</label>
        <textarea name="keterangan"
                  class="form-control">{{ old('keterangan', $transaksi->keterangan) }}</textarea>
    </div>

    @if($transaksi->bukti)
    <div class="mb-3">
        <label>Nota Saat Ini</label><br>
        @if(str_ends_with($transaksi->bukti, '.pdf'))
            <a href="{{ asset('storage/' . $transaksi->bukti) }}" target="_blank" class="btn btn-sm btn-info">Lihat PDF</a>
        @else
            <br>
            <img src="{{ asset('storage/' . $transaksi->bukti) }}" width="150" class="img-thumbnail">
        @endif
    </div>
    @endif

    <div class="mb-3">
        <label>Ganti Bukti (PDF / JPG / PNG)</label>
        <input type="file" name="bukti" class="form-control" accept=".jpg,.jpeg,.png,.pdf">
    </div>

    <button type="submit" class="btn btn-primary">
        Update
    </button>

    <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">
        Kembali
    </a>

</form>

@endsection