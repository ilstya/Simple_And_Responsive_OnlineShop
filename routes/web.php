<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\KatalogController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Pelanggan\DashboardController as PelangganDashboard;
use App\Http\Controllers\Pelanggan\PesananController;

// Home
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Auth routes (login, register, forgot password)
require __DIR__.'/auth.php';

// GET Logout fallback
Route::get('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout.get');

// Redirect after login
Route::middleware(['auth', 'verified'])->get('/dashboard', function () {
    return Auth::user()->role === 'admin'
        ? redirect()->route('admin.dashboard')
        : redirect()->route('pelanggan.dashboard');
})->name('dashboard');

// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes
Route::prefix('admin')
    ->middleware(['auth', 'admin'])
    ->name('admin.')
    ->group(function () {
        Route::get('dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

        Route::resource('katalog', KatalogController::class)->except(['show']);

        Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
        Route::put('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
        Route::post('orders/{order}/approve', [OrderController::class, 'approve'])->name('orders.approve');
        Route::post('orders/{order}/reject', [OrderController::class, 'reject'])->name('orders.reject');

        Route::prefix('payments')->name('payments.')->group(function () {
            Route::get('/', [PaymentController::class, 'index'])->name('index');
            Route::post('{payment}/verify', [PaymentController::class, 'verify'])->name('verify');
        });

        Route::prefix('reports')->name('reports.')->group(function () {
            Route::get('orders', [ReportController::class, 'ordersReport'])->name('orders');
        });
    });

// Pelanggan Routes
Route::prefix('pelanggan')
    ->middleware(['auth'])
    ->name('pelanggan.')
    ->group(function () {
        Route::get('dashboard', [PelangganDashboard::class, 'index'])->name('dashboard');

        Route::resource('pesanan', PesananController::class)->except(['show']);
        Route::get('pesanan/{pesanan}', [PesananController::class, 'show'])->name('pesanan.show');
        Route::post('pesanan/{pesanan}/upload', [PesananController::class, 'uploadBukti'])->name('pesanan.upload');
        Route::get('pesanan/{pesanan}/kwitansi', [PesananController::class, 'downloadKwitansi'])->name('pesanan.kwitansi');
    });
