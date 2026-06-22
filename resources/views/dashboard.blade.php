@extends('layouts.app')

@section('page-title', 'Dashboard')

@section('content')

@if(auth()->user()->role === 'admin')

<div class="row g-4 mb-4">

    <div class="col-md-3">
        <div class="card h-100" style="border-left: 4px solid #1a5c38;">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted mb-1" style="font-size:0.8rem;">KAS</p>
                    <h4 class="fw-bold" style="color:#1a5c38;">Rp {{ number_format($kas) }}</h4>
                </div>
                <div style="background:#e8f5ee; width:50px; height:50px; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:1.5rem;">
                    💰
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card h-100" style="border-left: 4px solid #0d6efd;">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted mb-1" style="font-size:0.8rem;">JUMLAH TRANSAKSI</p>
                    <h4 class="fw-bold text-primary">{{ $jumlah_transaksi }} Transaksi</h4>
                </div>
                <div style="background:#e8f0fe; width:50px; height:50px; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:1.5rem;">
                    🛒
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card h-100" style="border-left: 4px solid #fd7e14;">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted mb-1" style="font-size:0.8rem;">PENDAPATAN</p>
                    <h4 class="fw-bold text-warning">Rp {{ number_format($pendapatan) }}</h4>
                </div>
                <div style="background:#fff3e0; width:50px; height:50px; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:1.5rem;">
                    📈
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card h-100" style="border-left: 4px solid #dc3545;">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted mb-1" style="font-size:0.8rem;">KEUNTUNGAN</p>
                    <h4 class="fw-bold text-danger">Rp {{ number_format($keuntungan) }}</h4>
                </div>
                <div style="background:#fde8e8; width:50px; height:50px; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:1.5rem;">
                    🏆
                </div>
            </div>
        </div>
    </div>

</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center py-3"
         style="background-color:#1a5c38; border-radius:12px 12px 0 0;">
        <span class="text-white fw-semibold">
            <i class="bi bi-clock-history me-2"></i>Transaksi Terakhir
        </span>
        <a href="{{ route('transaksi.index') }}" class="btn btn-sm btn-light">Lihat Semua</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Total</th>
                        <th>Nota</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse(\App\Models\TransaksiHarian::latest()->take(5)->get() as $item)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_transaksi)->format('d M Y') }}</td>
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
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted py-4">
                            <i class="bi bi-inbox" style="font-size:2rem;"></i><br>Belum ada transaksi
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@else

{{-- DASHBOARD KASIR - diisi teman --}}

@endif

@endsection