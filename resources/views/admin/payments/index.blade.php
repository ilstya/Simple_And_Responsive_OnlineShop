@extends('layouts.admin')

@section('title', 'Daftar Pembayaran')

@section('content')
<div class="container py-4">
    <h1 class="h3 mb-4">Daftar Pembayaran</h1>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Pelanggan</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                            <th>Bukti</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($payments as $payment)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $payment->pesanan->pelanggan->nama ?? '-' }}</td>
                            <td>Rp{{ number_format($payment->jumlah, 0, ',', '.') }}</td>
                            <td>
                                @if($payment->status === 'verified')
                                    <span class="badge bg-success">Terverifikasi</span>
                                @else
                                    <span class="badge bg-warning">Pending</span>
                                @endif
                            </td>
                            <td>
                                @if($payment->bukti)
                                    <a href="{{ asset('storage/'.$payment->bukti) }}" target="_blank" class="btn btn-sm btn-info">Lihat Bukti</a>
                                @else
                                    <small class="text-muted">Tidak Ada</small>
                                @endif
                            </td>
                            <td>
                                @if($payment->status === 'pending')
                                    <form method="POST" action="{{ route('admin.payments.verify', $payment->id) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success">Verifikasi</button>
                                    </form>
                                @else
                                    <small class="text-muted">Sudah diverifikasi</small>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Belum ada pembayaran.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $payments->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
