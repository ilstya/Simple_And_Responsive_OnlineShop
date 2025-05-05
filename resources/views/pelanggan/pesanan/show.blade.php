@extends('layouts.pelanggan')

@section('title', 'Detail Pesanan')

@section('content')
<div class="container py-4">
    <h1 class="h3 mb-4">Detail Pesanan</h1>

    {{-- Data Pelanggan --}}
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Data Pelanggan</h5>
            <p><strong>Nama:</strong> {{ $pesanan->pelanggan->nama ?? '-' }}</p>
            <p><strong>Email:</strong> {{ $pesanan->pelanggan->email ?? '-' }}</p>
            <p><strong>Alamat:</strong> {{ $pesanan->pelanggan->alamat ?? '-' }}</p>
            <p><strong>No Telepon:</strong> {{ $pesanan->pelanggan->no_telepon ?? '-' }}</p>
        </div>
    </div>

    {{-- Informasi Pesanan --}}
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Informasi Pesanan</h5>
            <p><strong>Tanggal Pesan:</strong> {{ \Carbon\Carbon::parse($pesanan->tanggal_pesanan)->format('d M Y') }}</p>
            <p><strong>Status Pesanan:</strong> {{ $pesanan->status_pesanan }}</p>
            <p><strong>Total Harga:</strong> Rp{{ number_format($pesanan->harga, 0, ',', '.') }}</p>
        </div>
    </div>

    {{-- Detail Produk --}}
    <h4 class="mb-3">Detail Produk</h4>
    @foreach ($pesanan->detail as $detail)
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">{{ $detail->modelKatalog->Nama_model ?? '-' }}</h5>
            <p><strong>Bahan:</strong> {{ $detail->bahan }}</p>
            <p><strong>Ukuran:</strong> {{ $detail->ukuran }}</p>
            <p><strong>Jumlah:</strong> {{ $detail->jumlah }}</p>
            <p><strong>Harga Satuan:</strong> Rp{{ number_format($detail->harga_satuan, 0, ',', '.') }}</p>
        </div>
    </div>
    @endforeach

    {{-- Bukti Pembayaran --}}
    @if($pesanan->pembayaran)
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Bukti Pembayaran</h5>
                <p><strong>Status Pembayaran:</strong> {{ ucfirst($pesanan->pembayaran->status) }}</p>
                <p><strong>Jumlah Dibayar:</strong> Rp{{ number_format($pesanan->pembayaran->jumlah, 0, ',', '.') }}</p>
                <div class="mt-2">
                    <img src="{{ asset('storage/'.$pesanan->pembayaran->bukti) }}" alt="Bukti Pembayaran" class="img-fluid" style="max-width: 400px;">
                </div>

                {{-- Tombol Download Kwitansi jika sudah terverifikasi --}}
                @if($pesanan->pembayaran)
                <p class="text-muted">DEBUG: status = {{ $pesanan->pembayaran->status }}</p>

                @if($pesanan->pembayaran->status == 'verified')
                    <a href="{{ route('pelanggan.pesanan.kwitansi', $pesanan->id_pesanan) }}" class="btn btn-outline-primary">
                        Download Kwitansi
                    </a>
                @endif
            @endif
            </div>
        </div>
    @else
        {{-- Jika Belum Ada Bukti Pembayaran --}}
        @if($pesanan->status_pesanan == 'Dalam Proses' || $pesanan->status_pesanan == 'Siap Diambil')
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Upload Bukti Pembayaran</h5>

                <form method="POST" action="{{ route('pelanggan.pesanan.upload', $pesanan->id_pesanan) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="bukti" class="form-label">Upload Bukti</label>
                        <input type="file" name="bukti" id="bukti" class="form-control" accept="image/*" required>
                    </div>
                    <button type="submit" class="btn btn-success">Upload</button>
                </form>
            </div>
        </div>
        @else
        <div class="alert alert-info">
            Pesanan Anda sudah <strong>{{ $pesanan->status_pesanan }}</strong>. Tidak perlu upload bukti pembayaran lagi.
        </div>
        @endif
    @endif

    {{-- Tombol Kembali --}}
    <a href="{{ route('pelanggan.pesanan.index') }}" class="btn btn-secondary mt-3">Kembali ke Pesanan Saya</a>
</div>
@endsection
