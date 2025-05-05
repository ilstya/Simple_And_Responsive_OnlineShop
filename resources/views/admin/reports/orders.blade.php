@extends('layouts.admin')

@section('title', 'Laporan')

@section('content')
<div class="container py-4">
    <h1 class="h3 mb-4">Laporan Transaksi</h1>

    {{-- Filter --}}
    <form method="GET" action="{{ route('admin.reports.orders') }}" class="row g-3 mb-4">
        <div class="col-md-3">
            <label for="start_date" class="form-label">Dari Tanggal</label>
            <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}" class="form-control">
        </div>
        <div class="col-md-3">
            <label for="end_date" class="form-label">Sampai Tanggal</label>
            <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}" class="form-control">
        </div>
        <div class="col-md-3 align-self-end">
            <button type="submit" class="btn btn-primary">Tampilkan</button>
            <a href="{{ route('admin.reports.orders', ['export' => 'excel'] + request()->all()) }}" class="btn btn-success">
                <i class="bi bi-file-earmark-excel"></i> Export Excel
            </a>
            <a href="{{ route('admin.reports.orders', ['export' => 'pdf'] + request()->all()) }}" class="btn btn-danger">
                Export PDF
            </a>
        </div>
    </form>

    {{-- Data Pesanan --}}
    <div class="card mb-5">
        <div class="card-header bg-secondary text-white">Data Pesanan</div>
        <div class="card-body table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Nama Pelanggan</th>
                        <th>Tanggal</th>
                        <th>Total Harga</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pesanans as $index => $pesanan)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $pesanan->pelanggan->nama ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($pesanan->tanggal_pesanan)->format('d M Y') }}</td>
                            <td>Rp{{ number_format($pesanan->harga, 0, ',', '.') }}</td>
                            <td>{{ $pesanan->status_pesanan }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center">Tidak ada data pesanan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Data Pembayaran --}}
    <div class="card">
        <div class="card-header bg-secondary text-white">Data Pembayaran</div>
        <div class="card-body table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Nama Pelanggan</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($payments as $index => $pay)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $pay->pesanan->pelanggan->nama ?? '-' }}</td>
                            <td>Rp{{ number_format($pay->jumlah, 0, ',', '.') }}</td>
                            <td>
                                @if($pay->status === 'verified')
                                    <span class="badge bg-success">Terverifikasi</span>
                                @else
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @endif
                            </td>
                            <td>{{ \Carbon\Carbon::parse($pay->created_at)->format('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center">Tidak ada data pembayaran.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
