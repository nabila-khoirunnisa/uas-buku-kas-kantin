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
                        <th>Total</th>
                        <th>Nota</th>
                        <th>Status</th>
                        @if(auth()->user()->role === 'admin')
                            <th>Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaksi as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_transaksi)->format('d M Y') }}</td>
                        <td>
                            @foreach($item->details as $detail)
                                <span class="badge bg-secondary me-1">
                                    {{ $detail->produk->nama_produk ?? '-' }} x{{ $detail->jumlah }}
                                </span>
                            @endforeach
                        </td>
                        <td class="fw-bold text-success">Rp {{ number_format($item->total) }}</td>
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
                            <span class="badge bg-success">Tersimpan</span>
                        </td>
                        @if(auth()->user()->role === 'admin')
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
                        @endif
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ auth()->user()->role === 'admin' ? 7 : 6 }}"
                            class="text-center text-muted py-4">
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