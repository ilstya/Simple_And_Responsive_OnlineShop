@extends('layouts.admin')

@section('title', 'Tambah Produk Katalog')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4">Tambah Produk Katalog</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.katalog.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="nama_model" class="form-label">Nama Model</label>
            <input type="text" name="nama_model" class="form-control" id="nama_model" required>
        </div>

        <div class="mb-3">
            <label for="harga" class="form-label">Harga (Rp)</label>
            <input type="number" name="harga" class="form-control" id="harga" required>
        </div>

        <div class="mb-3">
            <label for="foto_model" class="form-label">Foto Model</label>
            <input type="file" name="foto_model" class="form-control" id="foto_model" accept="image/*">
        </div>

        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi" rows="4" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('admin.katalog.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
