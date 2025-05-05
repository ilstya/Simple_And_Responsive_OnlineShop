<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\ModelKatalog;
use App\Models\Pelanggan;
use App\Models\Payment;
use App\Models\DetailPesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PDF;

class PesananController extends Controller
{
    public function index()
    {
        $pelanggan = Pelanggan::where('email', auth()->user()->email)->firstOrFail();

        $pesanans = Pesanan::where('id_pelanggan', $pelanggan->id_pelanggan)
                    ->with('detail.modelKatalog', 'pembayaran') // Load detail dan pembayaran
                    ->orderByDesc('created_at')
                    ->paginate(10);

        return view('pelanggan.pesanan.index', compact('pesanans'));
    }

    public function create(Request $request)
    {
        $modelId = $request->query('model');

        if (!$modelId) {
            return redirect()->route('pelanggan.dashboard')->with('error', 'Model tidak ditemukan.');
        }

        return view('pelanggan.pesanan.create', compact('modelId'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_model' => 'required|exists:models,id_model',
            'tanggal_pesanan' => 'required|date',
            'bahan' => 'required|string|max:50',
            'ukuran' => 'required|string|max:20',
            'jumlah' => 'required|integer|min:1',
        ]);

        $model = ModelKatalog::findOrFail($request->id_model);
        $pelanggan = Pelanggan::where('email', auth()->user()->email)->firstOrFail();

        // Buat pesanan
        $pesanan = Pesanan::create([
            'id_pelanggan' => $pelanggan->id_pelanggan,
            'tanggal_pesanan' => $request->tanggal_pesanan,
            'status_pesanan' => 'Dalam Proses',
            'harga' => $model->harga * $request->jumlah,
        ]);

        // Buat detail pesanan
        DetailPesanan::create([
            'id_pesanan' => $pesanan->id_pesanan, // id_pesanan
            'id_model' => $model->id_model,
            'bahan' => $request->bahan,
            'ukuran' => $request->ukuran,
            'jumlah' => $request->jumlah,
            'harga_satuan' => $model->harga,
        ]);

        return redirect()->route('pelanggan.pesanan.index')->with('success', 'Pesanan berhasil dibuat.');
    }

    public function show(Pesanan $pesanan)
    {
        $pelanggan = Pelanggan::where('email', auth()->user()->email)->firstOrFail();

        if ($pesanan->id_pelanggan != $pelanggan->id_pelanggan) {
            abort(403, 'Akses ditolak.');
        }

        $pesanan->load('detail.modelKatalog', 'pembayaran', 'pelanggan');

        return view('pelanggan.pesanan.show', compact('pesanan'));
    }

    public function uploadBukti(Request $request, Pesanan $pesanan)
    {
        $pelanggan = Pelanggan::where('email', auth()->user()->email)->firstOrFail();

        if ($pesanan->id_pelanggan != $pelanggan->id_pelanggan) {
            abort(403, 'Akses ditolak.');
        }

        $request->validate([
            'bukti' => 'required|image|max:2048',
        ]);

        $path = $request->file('bukti')->store('bukti', 'public');

        Payment::create([
            'id_pesanan' => $pesanan->id_pesanan, //  id_pesanan
            'jumlah' => $pesanan->harga ?? 0,
            'bukti' => $path,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Bukti pembayaran berhasil diupload.');
    }

        public function downloadKwitansi(Pesanan $pesanan)
    {
        $pelanggan = Pelanggan::where('email', auth()->user()->email)->firstOrFail();

        if ($pesanan->id_pelanggan != $pelanggan->id_pelanggan) {
            abort(403, 'Akses ditolak.');
        }

        $pesanan->load('detail.modelKatalog', 'pembayaran');

        $pdf = PDF::loadView('pelanggan.pesanan.kwitansi', compact('pesanan'));
        return $pdf->download('kwitansi_pesanan_'.$pesanan->id_pesanan.'.pdf');
    }
}
