<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KiosController;
use App\Http\Controllers\TransaksiHarianController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {

    // Kios - semua user bisa lihat index
    Route::resource('kios', KiosController::class)->only(['index']);

    // Khusus admin
    Route::middleware('admin')->group(function () {
        Route::resource('transaksi', TransaksiHarianController::class);
        Route::resource('kios', KiosController::class)->except(['index']);
        Route::resource('produk', ProdukController::class);
    });

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';