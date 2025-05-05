@extends('layouts.pelanggan')

@section('title', 'Buat Pesanan')

@section('content')
<div class="container py-4">
    <h1 class="h3 mb-4">Buat Pesanan Baru</h1>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('pelanggan.pesanan.store') }}">
        @csrf

        {{-- Kirim id_model --}}
        <input type="hidden" name="id_model" value="{{ $modelId }}">

        <div class="mb-3">
            <label for="tanggal_pesanan" class="form-label">Tanggal Pesanan</label>
            <input type="date" name="tanggal_pesanan" id="tanggal_pesanan" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="bahan" class="form-label">Bahan</label>
            <select name="bahan" id="bahan" class="form-control" required>
                <option value="">-- Pilih Bahan --</option>
                <option value="Katun">Katun</option>
                <option value="Sutra">Sutra</option>
                <option value="Drill">Drill</option>
                <option value="Denim">Denim</option>
                <option value="Linen">Linen</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="ukuran" class="form-label">Ukuran</label>
            <select name="ukuran" id="ukuran" class="form-control" required>
                <option value="">-- Pilih Ukuran --</option>
                <option value="S">S</option>
                <option value="M">M</option>
                <option value="L">L</option>
                <option value="XL">XL</option>
                <option value="XXL">XXL</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="jumlah" class="form-label">Jumlah</label>
            <input type="number" name="jumlah" id="jumlah" class="form-control" value="1" min="1" required>
        </div>

        <button type="submit" class="btn btn-primary">Pesan Sekarang</button>
    </form>

    <div class="mt-3">
        <a href="{{ route('pelanggan.dashboard') }}" class="btn btn-secondary">Batal</a>
    </div>
</div>
@endsection
