@extends('layouts.admin')

@section('title', 'Daftar Pembayaran')

@section('content')
<div class="container py-4">
    <h1 class="h3 mb-4">Daftar Pembayaran</h1>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle table-hover table-striped">
                    <thead class="table-primary">
                        <tr>
                            <th>#</th>
                            <th>Nama Pelanggan</th>
                            <th>Tanggal Pesanan</th>
                            <th>Total Harga</th>
                            <th>Status Pembayaran</th> 
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $order->pelanggan->nama ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($order->tanggal_pesanan)->format('d M Y') }}</td>
                            <td>Rp{{ number_format($order->harga, 0, ',', '.') }}</td>
                            <td>
                                @if($order->status_pesanan == 'Dalam Proses')
                                    <span class="badge bg-warning">Menunggu Verifikasi</span>
                                @elseif($order->status_pesanan == 'Selesai')
                                    <span class="badge bg-success">Terverifikasi</span>
                                @elseif($order->status_pesanan == 'Siap Diambil')
                                    <span class="badge bg-info">Siap Diambil</span>
                                @elseif($order->status_pesanan == 'Ditolak')
                                    <span class="badge bg-danger">Ditolak</span>
                                @else
                                    <span class="badge bg-secondary">{{ $order->status_pesanan }}</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.orders.show', $order->id_pesanan) }}" class="btn btn-sm btn-primary">
                                    <i class="bi bi-eye"></i> Lihat
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Belum ada data pembayaran.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
