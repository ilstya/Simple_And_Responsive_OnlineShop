<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\ModelKatalog;
use App\Models\Pesanan;
use App\Models\Pelanggan;

class DashboardController extends Controller
{
    public function index()
{
    $pelanggan = Pelanggan::where('email', auth()->user()->email)->first();

    if (!$pelanggan) {
        return redirect()->route('logout')->with('error', 'Data pelanggan tidak ditemukan. Silakan hubungi admin.');
    }

    $jumlahPesanan = Pesanan::where('id_pelanggan', $pelanggan->id_pelanggan)->count();
    $pesananProses = Pesanan::where('id_pelanggan', $pelanggan->id_pelanggan)->where('status_pesanan', 'Dalam Proses')->count();
    $pesananSelesai = Pesanan::where('id_pelanggan', $pelanggan->id_pelanggan)->where('status_pesanan', 'Selesai')->count();

    $katalogs = ModelKatalog::latest()->paginate(6); // Ubah ke paginate!

    return view('pelanggan.dashboard', compact('katalogs', 'jumlahPesanan', 'pesananProses', 'pesananSelesai'));
}

}
