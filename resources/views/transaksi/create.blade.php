@extends('layouts.app')

@section('page-title', 'Tambah Transaksi')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-bold mb-0" style="color:#1a5c38;">
        <i class="bi bi-plus-circle me-2"></i>Tambah Transaksi
    </h5>
    <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
</div>

@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card">
    <div class="card-body">
        <form action="{{ route('transaksi.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label fw-semibold">Tanggal Transaksi</label>
                <input type="date" name="tanggal_transaksi" class="form-control"
                       value="{{ old('tanggal_transaksi') }}">
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Produk</label>
                <select name="produk_id" class="form-control" id="produkSelect"
                        onchange="updateHarga(this)">
                    <option value="">Pilih Produk</option>
                    @foreach($produk as $item)
                        <option value="{{ $item->id }}"
                                data-harga-pokok="{{ $item->harga_pokok }}"
                                data-harga-jual="{{ $item->harga_jual }}"
                                {{ old('produk_id') == $item->id ? 'selected' : '' }}>
                            {{ $item->nama_produk }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Harga Pokok</label>
                    <input type="text" id="harga_pokok" class="form-control" readonly
                           placeholder="Otomatis dari produk">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Harga Jual</label>
                    <input type="text" id="harga_jual" class="form-control" readonly
                           placeholder="Otomatis dari produk">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Jumlah</label>
                <input type="number" name="jumlah" class="form-control" min="1"
                       value="{{ old('jumlah') }}" onchange="updateTotal()" oninput="updateTotal()">
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Total</label>
                <input type="text" id="total_display" class="form-control" readonly
                       placeholder="Otomatis dihitung">
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Nota / Bukti</label>
                <input type="file" name="bukti" class="form-control"
                       accept=".jpg,.jpeg,.png,.pdf">
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save me-1"></i> Simpan
            </button>
        </form>
    </div>
</div>

<script>
function updateHarga(select) {
    const option = select.options[select.selectedIndex];
    const hargaPokok = option.dataset.hargaPokok || '';
    const hargaJual = option.dataset.hargaJual || '';

    document.getElementById('harga_pokok').value = hargaPokok
        ? 'Rp ' + parseInt(hargaPokok).toLocaleString('id-ID') : '';
    document.getElementById('harga_jual').value = hargaJual
        ? 'Rp ' + parseInt(hargaJual).toLocaleString('id-ID') : '';

    updateTotal();
}

function updateTotal() {
    const select = document.getElementById('produkSelect');
    const option = select.options[select.selectedIndex];
    const hargaJual = parseFloat(option.dataset.hargaJual) || 0;
    const jumlah = parseInt(document.querySelector('[name=jumlah]').value) || 0;
    const total = hargaJual * jumlah;

    document.getElementById('total_display').value = total
        ? 'Rp ' + total.toLocaleString('id-ID') : '';
}
</script>

@endsection