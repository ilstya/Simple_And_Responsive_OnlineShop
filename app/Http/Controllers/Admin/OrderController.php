<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Menampilkan semua daftar pesanan
    public function index()
    {
        $orders = Pesanan::with(['pelanggan', 'pembayaran'])->latest()->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }

    // Menampilkan detail pesanan
    public function show(Pesanan $order)
    {
        $order->load('pelanggan', 'detail.modelKatalog', 'pembayaran');

        return view('admin.orders.show', compact('order'));
    }

    // Update status pesanan secara manual
    public function updateStatus(Request $request, Pesanan $order)
    {
        $request->validate([
            'status_pesanan' => 'required|in:Dalam Proses,Selesai,Siap Diambil,Ditolak',
        ]);

        $order->update([
            'status_pesanan' => $request->status_pesanan
        ]);

        return back()->with('success', 'Status pesanan berhasil diperbarui.');
    }

    // Approve pesanan, otomatis status "Dalam Proses"
    public function approve(Pesanan $order)
    {
        $order->update([
            'status_pesanan' => 'Dalam Proses'
        ]);

        return back()->with('success', 'Pesanan berhasil disetujui.');
    }

    // Reject pesanan
    public function reject(Pesanan $order)
    {
        $order->update([
            'status_pesanan' => 'Ditolak'
        ]);

        return back()->with('success', 'Pesanan berhasil ditolak.');
    }
}
