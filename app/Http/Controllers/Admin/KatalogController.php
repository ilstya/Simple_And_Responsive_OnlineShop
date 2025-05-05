<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ModelKatalog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KatalogController extends Controller
{
    public function index()
    {
        $katalogs = ModelKatalog::orderBy('Nama_model')->paginate(10);
        return view('admin.katalog.index', compact('katalogs'));
    }

    public function create()
    {
        return view('admin.katalog.create');
    }

    public function store(Request $req)
    {
        $req->validate([
            'nama_model' => 'required|string|max:150',
            'harga' => 'required|numeric',
            'foto_model' => 'nullable|image|max:2048',
            'deskripsi' => 'nullable|string',
        ]);

        $path = $req->file('foto_model')
            ? $req->file('foto_model')->store('models', 'public')
            : null;

        ModelKatalog::create([
            'Nama_model' => $req->nama_model,
            'harga' => $req->harga,
            'Foto_model' => $path,
            'deskripsi' => $req->deskripsi,
        ]);

        return redirect()->route('admin.katalog.index')
                         ->with('success', 'Produk katalog berhasil ditambahkan.');
    }

    public function edit(ModelKatalog $katalog)
    {
        return view('admin.katalog.edit', compact('katalog'));
    }

    public function update(Request $req, ModelKatalog $katalog)
    {
        $req->validate([
            'nama_model' => 'required|string|max:150',
            'harga' => 'required|numeric',
            'foto_model' => 'nullable|image|max:2048',
            'deskripsi' => 'nullable|string',
        ]);

        if ($req->hasFile('foto_model')) {
            if ($katalog->Foto_model) {
                Storage::disk('public')->delete($katalog->Foto_model);
            }
            $katalog->Foto_model = $req->file('foto_model')->store('models', 'public');
        }

        $katalog->update([
            'Nama_model' => $req->nama_model,
            'harga' => $req->harga,
            'deskripsi' => $req->deskripsi,
        ]);

        return redirect()->route('admin.katalog.index')
                         ->with('success', 'Produk katalog berhasil diperbarui.');
    }

    public function destroy(ModelKatalog $katalog)
    {
        if ($katalog->Foto_model) {
            Storage::disk('public')->delete($katalog->Foto_model);
        }
        $katalog->delete();

        return back()->with('success', 'Produk katalog berhasil dihapus.');
    }
}
