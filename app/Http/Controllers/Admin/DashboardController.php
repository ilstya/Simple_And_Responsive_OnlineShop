<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalThisMonth = Pesanan::whereMonth('tanggal_pesanan', now()->month)->count();
        $totalAllTime = Pesanan::count();
        $totalCustomers = User::where('role', 'pelanggan')->count();

        $chartLabels = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        // Contoh dummy chart data
        $chartData = [5, 10, 7, 15, 20, 12, 8, 18, 25, 22, 19, 30];

        return view('admin.dashboard', compact(
            'totalThisMonth',
            'totalAllTime',
            'totalCustomers',
            'chartLabels',
            'chartData'
        ));
    }
}
