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

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {

    // Semua user bisa lihat kios
    Route::resource('kios', KiosController::class)
        ->only(['index']);

    // Semua user bisa lihat produk
    Route::resource('produk', ProdukController::class)
        ->only(['index']);

    Route::resource('transaksi', TransaksiHarianController::class);

    // Khusus admin
    Route::middleware('admin')->group(function () {

        Route::resource('kios', KiosController::class)
            ->except(['index']);

        Route::resource('produk', ProdukController::class)
            ->except(['index']);
    });

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';