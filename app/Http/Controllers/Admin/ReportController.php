<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\Payment;
use Illuminate\Http\Request;
use Spatie\SimpleExcel\SimpleExcelWriter;
use Barryvdh\DomPDF\Facade\Pdf;


class ReportController extends Controller
{
    public function ordersReport(Request $request)
{
    $start = $request->start;
    $end = $request->end;

    $pesanans = Pesanan::with('pelanggan')
        ->when($start && $end, function ($query) use ($start, $end) {
            $query->whereBetween('tanggal_pesanan', [$start, $end]);
        })
        ->orderByDesc('created_at')
        ->get();

    $payments = Payment::with('pesanan.pelanggan')
        ->when($start && $end, function ($query) use ($start, $end) {
            $query->whereBetween('created_at', [$start, $end]);
        })
        ->orderByDesc('created_at')
        ->get();

    // Export ke Excel (Pesanan)
    if ($request->has('export') && $request->export === 'pesanan') {
        $filePath = storage_path('app/public/laporan-pesanan.csv');
        \Spatie\SimpleExcel\SimpleExcelWriter::create($filePath)
            ->addHeader(['Nama Pelanggan', 'Tanggal Pesanan', 'Total Harga', 'Status Pesanan'])
            ->addRows($pesanans->map(function ($item) {
                return [
                    'Nama Pelanggan' => $item->pelanggan->nama ?? '-',
                    'Tanggal Pesanan' => \Carbon\Carbon::parse($item->tanggal_pesanan)->format('d-m-Y'),
                    'Total Harga' => number_format($item->harga, 0, ',', '.'),
                    'Status Pesanan' => $item->status_pesanan,
                ];
            })->toArray());

        return response()->download($filePath)->deleteFileAfterSend(true);
    }

    // Export ke Excel (Pembayaran)
    if ($request->has('export') && $request->export === 'pembayaran') {
        $filePath = storage_path('app/public/laporan-pembayaran.csv');
        \Spatie\SimpleExcel\SimpleExcelWriter::create($filePath)
            ->addHeader(['Nama Pelanggan', 'Jumlah Dibayar', 'Status Pembayaran', 'Tanggal Pembayaran'])
            ->addRows($payments->map(function ($item) {
                return [
                    'Nama Pelanggan' => $item->pesanan->pelanggan->nama ?? '-',
                    'Jumlah Dibayar' => number_format($item->jumlah, 0, ',', '.'),
                    'Status Pembayaran' => ucfirst($item->status),
                    'Tanggal Pembayaran' => \Carbon\Carbon::parse($item->created_at)->format('d-m-Y'),
                ];
            })->toArray());

        return response()->download($filePath)->deleteFileAfterSend(true);
    }

    // Export PDF
    if ($request->has('export') && $request->export === 'pdf') {
        $pdf = Pdf::loadView('admin.reports.pdf', compact('pesanans', 'payments', 'start', 'end'));
        return $pdf->download('laporan-transaksi.pdf');
    }

    return view('admin.reports.orders', compact('pesanans', 'payments', 'start', 'end'));
}

}
