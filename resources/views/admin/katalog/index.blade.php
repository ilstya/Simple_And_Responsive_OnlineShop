@extends('layouts.admin')

@section('title', 'Kelola Katalog')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Kelola Katalog</h1>
        <a href="{{ route('admin.katalog.create') }}" class="btn btn-primary">Tambah Produk</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Produk</th>
                            <th>Harga</th>
                            <th>Foto</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($katalogs as $katalog)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $katalog->Nama_model }}</td>
                            <td>Rp{{ number_format($katalog->harga, 0, ',', '.') }}</td>
                            <td>
                                @if($katalog->Foto_model)
                                    <img src="{{ asset('storage/'.$katalog->Foto_model) }}" width="80" alt="">
                                @else
                                    <small class="text-muted">Tidak ada foto</small>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.katalog.edit', ['katalog' => $katalog->id_model]) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('admin.katalog.destroy', ['katalog' => $katalog->id_model]) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin mau hapus?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Belum ada data katalog.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $katalogs->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
