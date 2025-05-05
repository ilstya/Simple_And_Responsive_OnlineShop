@extends('layouts.pelanggan')

@section('title', 'Pesanan Saya')

@section('content')
<div class="container py-4">
    <h1 class="h3 mb-4">Pesanan Saya</h1>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Model</th>
                            <th>Tanggal Pesanan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pesanans as $pesanan)
                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            {{-- Karena satu pesanan bisa punya banyak detail --}}
                            <td>
                                @foreach ($pesanan->detail as $detail)
                                    {{ $detail->modelKatalog->Nama_model ?? '-' }}<br>
                                @endforeach
                            </td>

                            <td>{{ \Carbon\Carbon::parse($pesanan->tanggal_pesanan)->format('d M Y') }}</td>

                            <td>
                                @if($pesanan->status_pesanan == 'Dalam Proses')
                                    <span class="badge bg-warning">Dalam Proses</span>
                                @elseif($pesanan->status_pesanan == 'Selesai')
                                    <span class="badge bg-success">Selesai</span>
                                @elseif($pesanan->status_pesanan == 'Siap Diambil')
                                    <span class="badge bg-info">Siap Diambil</span>
                                @elseif($pesanan->status_pesanan == 'Ditolak')
                                    <span class="badge bg-danger">Ditolak</span>
                                @else
                                    <span class="badge bg-secondary">{{ $pesanan->status_pesanan }}</span>
                                @endif
                            </td>

                            <td>
                                <a href="{{ route('pelanggan.pesanan.show', $pesanan->id_pesanan) }}" class="btn btn-sm btn-info">Detail</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Belum ada pesanan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $pesanans->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
