@extends('layouts.app')

@section('content')

<h2 class="mb-4">Tambah Transaksi Harian</h2>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('transaksi.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="mb-3">
        <label>Tanggal Transaksi</label>
        <input type="date" name="tanggal_transaksi" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Bukti (opsional)</label>
        <input type="file" name="bukti" class="form-control">
    </div>

    <hr>

    <h5>Detail Produk</h5>

    <div id="produk-wrapper">

        <div class="row mb-2 produk-item">
            <div class="col-md-6">
                <select name="produk_id[]" class="form-control" required>
                    <option value="">-- Pilih Produk --</option>
                    @foreach ($produk as $p)
                        <option value="{{ $p->id }}">
                            {{ $p->nama_produk }} - Rp {{ number_format($p->harga_jual) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4">
                <input type="number" name="jumlah[]" class="form-control" placeholder="Jumlah" min="1" required>
            </div>

            <div class="col-md-2">
                <button type="button" class="btn btn-danger remove-item">Hapus</button>
            </div>
        </div>

    </div>

    <button type="button" class="btn btn-secondary mb-3" id="add-item">
        + Tambah Produk
    </button>

    <br>

    <button type="submit" class="btn btn-primary">
        Simpan Transaksi
    </button>

</form>

<script>
document.getElementById('add-item').addEventListener('click', function () {
    let wrapper = document.getElementById('produk-wrapper');

    let newItem = document.querySelector('.produk-item').cloneNode(true);

    // reset value
    newItem.querySelector('select').value = '';
    newItem.querySelector('input').value = '';

    wrapper.appendChild(newItem);
});

// hapus item
document.addEventListener('click', function (e) {
    if (e.target.classList.contains('remove-item')) {
        let items = document.querySelectorAll('.produk-item');
        if (items.length > 1) {
            e.target.closest('.produk-item').remove();
        }
    }
});
</script>

@endsection