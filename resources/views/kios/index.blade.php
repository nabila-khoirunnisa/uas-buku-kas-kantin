@extends('layouts.app')

@section('content')

<h2 class="mb-4">Data Kios</h2>

@if(auth()->user()->role == 'admin')
<a href="{{ route('kios.create') }}" class="btn btn-success mb-3">
    Tambah Kios
</a>
@endif

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<table class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Kios</th>
            <th>Nama Pemilik</th>
            <th>Jenis Dagangan</th>

            @if(auth()->user()->role == 'admin')
                <th>Aksi</th>
            @endif
        </tr>
    </thead>

    <tbody>
        @forelse($kios as $item)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->nama_kios }}</td>
            <td>{{ $item->nama_pemilik }}</td>
            <td>{{ $item->jenis_dagangan }}</td>

            @if(auth()->user()->role == 'admin')
            <td>
                <a href="{{ route('kios.edit', $item->id) }}"
                   class="btn btn-warning btn-sm">
                    Edit
                </a>

                <form action="{{ route('kios.destroy', $item->id) }}"
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
            @endif

        </tr>
        @empty
        <tr>
            <td colspan="5" class="text-center">
                Belum ada data kios
            </td>
        </tr>
        @endforelse
    </tbody>

</table>

@endsection