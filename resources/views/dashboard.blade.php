@extends('layouts.app')

@section('page-title', 'Dashboard')

@section('content')

@if(auth()->user()->role === 'admin')

{{-- DASHBOARD ADMIN --}}
<div class="row g-4 mb-4">

    <div class="col-md-4">
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

    <div class="col-md-4">
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

    <div class="col-md-4">
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

    <div class="col-md-6">
        <div class="card h-100" style="border-left: 4px solid #6f42c1;">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted mb-1" style="font-size:0.8rem;">LABA</p>
                    <h4 class="fw-bold" style="color:#6f42c1;">Rp {{ number_format($laba) }}</h4>
                </div>
                <div style="background:#f3e8ff; width:50px; height:50px; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:1.5rem;">
                    💹
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card h-100" style="border-left: 4px solid #dc3545;">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted mb-1" style="font-size:0.8rem;">KEUNTUNGAN (PENDAPATAN - HPP)</p>
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
         style="background-color:#0d6efd; border-radius:12px 12px 0 0;">
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
                        <th>Produk</th>
                        <th>Harga Jual</th>
                        <th>Jumlah</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse(\App\Models\TransaksiHarian::with('produk')->latest()->take(5)->get() as $item)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_transaksi)->format('d M Y') }}</td>
                        <td>{{ $item->produk->nama_produk ?? '-' }}</td>
                        <td class="text-success fw-semibold">Rp {{ number_format($item->harga_jual) }}</td>
                        <td>{{ $item->jumlah }}</td>
                        <td class="fw-bold">Rp {{ number_format($item->total) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">
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

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center py-3"
         style="background-color:#0d6efd; border-radius:12px 12px 0 0;">
        <span class="text-white fw-semibold">
            <i class="bi bi-box-seam me-2"></i>Daftar Produk Kantin
        </span>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Produk</th>
                        <th>Harga Jual</th>
                        <th>Stok / Hari</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($produk as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->nama_produk }}</td>
                        <td class="text-success fw-semibold">
                            Rp {{ number_format($item->harga_jual) }}
                        </td>
                        <td>{{ $item->stok_perhari }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">
                            Belum ada produk
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>


@endif

@endsection