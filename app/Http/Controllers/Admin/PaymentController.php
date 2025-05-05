<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('pesanan.pelanggan')->latest()->paginate(10);
        return view('admin.payments.index', compact('payments'));
    }

    public function verify(Payment $payment)
    {
        // Mulai transaksi DB untuk memastikan konsistensi
        \DB::transaction(function () use ($payment) {
            // Update status pembayaran ke 'verified'
            $payment->update([
                'status' => 'verified'
            ]);

            // Update status pesanan ke 'Selesai'
            $payment->pesanan()->update([
                'status_pesanan' => 'Selesai'
            ]);
        });

        return back()->with('success', 'Pembayaran diverifikasi dan pesanan diselesaikan.');
    }
}
