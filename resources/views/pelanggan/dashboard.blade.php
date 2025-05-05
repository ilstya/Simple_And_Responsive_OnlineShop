@extends('layouts.pelanggan')

@section('title', 'Dashboard Pelanggan')

@section('content')
<div class="container py-4">

    {{-- Profil Pengguna --}}
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">Profil Anda</div>
        <div class="card-body">
            <p><strong>Nama:</strong> {{ auth()->user()->name }}</p>
            <p><strong>Email:</strong> {{ auth()->user()->email }}</p>

            <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary">
                Ubah Profil & Password
            </a>
        </div>
    </div>

    {{-- Banner Statis --}}
    <div class="mb-4">
        <img src="{{ asset('storage/images/banner1.jpg') }}" class="w-100 rounded shadow" alt="Banner Promo">
    </div>

    {{-- Statistik Pesanan --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-white bg-info">
                <div class="card-body">
                    <h5>Total Pesanan</h5>
                    <h3>{{ $jumlahPesanan }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <h5>Dalam Proses</h5>
                    <h3>{{ $pesananProses }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5>Selesai</h5>
                    <h3>{{ $pesananSelesai }}</h3>
                </div>
            </div>
        </div>
    </div>

    {{-- Produk Terbaru --}}
    <h4 class="mb-3">Model Terbaru</h4>
    <div class="row">
        @forelse ($katalogs as $katalog)
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
                <img src="{{ asset('storage/' . $katalog->Foto_model) }}" class="card-img-top" alt="...">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">{{ $katalog->Nama_model }}</h5>
                    <p class="card-text">Rp{{ number_format($katalog->harga, 0, ',', '.') }}</p>
                    <a href="{{ route('pelanggan.pesanan.create', ['model' => $katalog->id_model]) }}" class="btn btn-primary mt-auto">Pesan Sekarang</a>
                </div>
            </div>
        </div>
        @empty
        <p class="text-center">Belum ada produk tersedia.</p>
        @endforelse
    </div>
</div>
@endsection
