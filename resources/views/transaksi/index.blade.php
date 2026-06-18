@extends('layouts.app')

@section('page-title', 'Data Transaksi')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-bold mb-0" style="color:#1a5c38;">
        <i class="bi bi-receipt me-2"></i>Data Transaksi Kantin
    </h5>
    <a href="{{ route('transaksi.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Tambah Transaksi
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Produk</th>
                        <th>Harga Pokok</th>
                        <th>Harga Jual</th>
                        <th>Jumlah</th>
                        <th>Total</th>
                        <th>Nota</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaksi as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_transaksi)->format('d M Y') }}</td>
                        <td class="fw-semibold">{{ $item->produk->nama_produk ?? '-' }}</td>
                        <td class="text-danger">Rp {{ number_format($item->harga_pokok) }}</td>
                        <td class="text-success">Rp {{ number_format($item->harga_jual) }}</td>
                        <td>{{ $item->jumlah }}</td>
                        <td class="fw-bold">Rp {{ number_format($item->total) }}</td>
                        <td>
                            @if($item->bukti)
                                <a href="{{ asset('storage/' . $item->bukti) }}" target="_blank"
                                   class="btn btn-sm btn-outline-info">
                                    <i class="bi bi-file-earmark"></i> Lihat
                                </a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('transaksi.edit', $item->id) }}"
                               class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('transaksi.destroy', $item->id) }}"
                                  method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Yakin hapus data ini?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted py-4">
                            <i class="bi bi-inbox" style="font-size:2rem;"></i><br>
                            Belum ada data transaksi
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($transaksi->hasPages())
    <div class="card-footer">
        {{ $transaksi->links() }}
    </div>
    @endif
</div>

@endsection