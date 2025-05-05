@extends('layouts.admin')

@section('title', 'Detail Pesanan')

@section('content')
<div class="container py-4">
    <h1 class="h3 mb-4">Detail Pesanan</h1>

    {{-- Data Pelanggan --}}
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Data Pelanggan</h5>
            <p><strong>Nama:</strong> {{ $order->pelanggan->nama ?? '-' }}</p>
            <p><strong>Email:</strong> {{ $order->pelanggan->email ?? '-' }}</p>
            <p><strong>Alamat:</strong> {{ $order->pelanggan->alamat ?? '-' }}</p>
            <p><strong>No Telepon:</strong> {{ $order->pelanggan->no_telepon ?? '-' }}</p>
        </div>
    </div>

    {{-- Informasi Pesanan --}}
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Informasi Pesanan</h5>
            <p><strong>Tanggal Pesanan:</strong> {{ \Carbon\Carbon::parse($order->tanggal_pesanan)->format('d M Y') }}</p>
            <p><strong>Status Pesanan:</strong> {{ $order->status_pesanan }}</p>
            <p><strong>Total Harga:</strong> Rp{{ number_format($order->harga, 0, ',', '.') }}</p>
        </div>
    </div>

    {{-- Detail Produk --}}
    <h4 class="mb-3">Produk Dipesan</h4>
    @foreach ($order->detail as $detail)
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
    @if($order->pembayaran)
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Bukti Pembayaran</h5>
            <p><strong>Status Pembayaran:</strong> {{ $order->pembayaran->status }}</p>
            <p><strong>Jumlah Bayar:</strong> Rp{{ number_format($order->pembayaran->jumlah, 0, ',', '.') }}</p>
            <div class="mt-2">
                <img src="{{ asset('storage/'.$order->pembayaran->bukti) }}" alt="Bukti Pembayaran" class="img-fluid" style="max-width: 400px;">
            </div>
        </div>
    </div>
    @endif

    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Kembali ke Daftar Pesanan</a>
</div>
@endsection
