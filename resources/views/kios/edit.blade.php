@extends('layouts.app')

@section('content')

<h2 class="mb-4">Edit Kios</h2>

@if ($errors->any())
<div class="alert alert-danger">
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('kios.update', $kios->id) }}" method="POST">

    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Nama Kios</label>
        <input type="text"
               name="nama_kios"
               class="form-control"
               value="{{ old('nama_kios', $kios->nama_kios) }}">
    </div>

    <div class="mb-3">
        <label>Nama Pemilik</label>
        <input type="text"
               name="nama_pemilik"
               class="form-control"
               value="{{ old('nama_pemilik', $kios->nama_pemilik) }}">
    </div>

    <div class="mb-3">
        <label>Jenis Dagangan</label>
        <input type="text"
               name="jenis_dagangan"
               class="form-control"
               value="{{ old('jenis_dagangan', $kios->jenis_dagangan) }}">
    </div>

    <button type="submit" class="btn btn-primary">
        Update
    </button>

    <a href="{{ route('kios.index') }}"
       class="btn btn-secondary">
        Kembali
    </a>

</form>

@endsection