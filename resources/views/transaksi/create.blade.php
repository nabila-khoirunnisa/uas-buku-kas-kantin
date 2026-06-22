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

            {{-- Tabel Produk --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">Produk</label>
                <div class="table-responsive">
                    <table class="table table-bordered" id="tabel-produk">
                        <thead class="table-dark">
                            <tr>
                                <th>Produk</th>
                                <th>Harga Pokok</th>
                                <th>Harga Jual</th>
                                <th>Jumlah</th>
                                <th>Subtotal</th>
                                <th>
                                    <button type="button" class="btn btn-sm btn-success"
                                            onclick="tambahBaris()">
                                        <i class="bi bi-plus"></i>
                                    </button>
                                </th>
                            </tr>
                        </thead>
                        <tbody id="body-produk">
                            <tr>
                                <td>
                                    <select name="produk_id[]" class="form-control produk-select"
                                            onchange="updateBaris(this)">
                                        <option value="">Pilih Produk</option>
                                        @foreach($produk as $item)
                                            <option value="{{ $item->id }}"
                                                    data-harga-pokok="{{ $item->harga_pokok }}"
                                                    data-harga-jual="{{ $item->harga_jual }}">
                                                {{ $item->nama_produk }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td><input type="text" class="form-control harga-pokok" readonly></td>
                                <td><input type="text" class="form-control harga-jual" readonly></td>
                                <td><input type="number" name="jumlah[]" class="form-control jumlah"
                                           min="1" value="1" oninput="updateSubtotal(this)"></td>
                                <td><input type="text" class="form-control subtotal" readonly></td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-danger"
                                            onclick="hapusBaris(this)">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" class="text-end fw-bold">Total</td>
                                <td colspan="2">
                                    <input type="text" id="total-keseluruhan"
                                           class="form-control fw-bold" readonly>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
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
const produkData = {};
@foreach($produk as $p)
produkData[{{ $p->id }}] = {
    id: {{ $p->id }},
    nama_produk: "{{ $p->nama_produk }}",
    harga_pokok: {{ $p->harga_pokok }},
    harga_jual: {{ $p->harga_jual }}
};
@endforeach

function tambahBaris() {
    const tbody = document.getElementById('body-produk');
    const baris = tbody.rows[0].cloneNode(true);

    baris.querySelectorAll('input').forEach(i => i.value = i.type === 'number' ? 1 : '');
    baris.querySelector('select').value = '';

    tbody.appendChild(baris);
}

function hapusBaris(btn) {
    const tbody = document.getElementById('body-produk');
    if (tbody.rows.length > 1) {
        btn.closest('tr').remove();
        updateTotal();
    }
}

function updateBaris(select) {
    const row = select.closest('tr');
    const id = select.value;

    if (id && produkData[id]) {
        const p = produkData[id];
        row.querySelector('.harga-pokok').value = 'Rp ' + parseInt(p.harga_pokok).toLocaleString('id-ID');
        row.querySelector('.harga-jual').value = 'Rp ' + parseInt(p.harga_jual).toLocaleString('id-ID');
    } else {
        row.querySelector('.harga-pokok').value = '';
        row.querySelector('.harga-jual').value = '';
        row.querySelector('.subtotal').value = '';
    }
    updateSubtotal(row.querySelector('.jumlah'));
}

function updateSubtotal(input) {
    const row = input.closest('tr');
    const select = row.querySelector('.produk-select');
    const id = select.value;
    const jumlah = parseInt(input.value) || 0;

    if (id && produkData[id]) {
        const subtotal = produkData[id].harga_jual * jumlah;
        row.querySelector('.subtotal').value = 'Rp ' + subtotal.toLocaleString('id-ID');
    }
    updateTotal();
}

function updateTotal() {
    let total = 0;
    document.querySelectorAll('#body-produk tr').forEach(row => {
        const select = row.querySelector('.produk-select');
        const jumlah = parseInt(row.querySelector('.jumlah').value) || 0;
        const id = select ? select.value : '';
        if (id && produkData[id]) {
            total += produkData[id].harga_jual * jumlah;
        }
    });
    document.getElementById('total-keseluruhan').value = 'Rp ' + total.toLocaleString('id-ID');
}
</script>

@endsection