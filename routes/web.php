<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminKategoriController;
use App\Http\Controllers\AdminProdukController;
use App\Http\Controllers\AdminTransaksiController;
use App\Http\Controllers\AdminUserController;

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect('/admin/dashboard');
});

Route::get('/login',  [AdminAuthController::class, 'index'])->name('login');
Route::post('/login', [AdminAuthController::class, 'doLogin'])->name('login.action');
Route::post('/logout',[AdminAuthController::class, 'logout'])->name('logout');
/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->middleware('auth')->group(function () {

    // ===== DASHBOARD =====
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/', function () {
        return redirect('/admin/dashboard');
    });

    // ===== KHUSUS ADMIN =====
    Route::middleware('role:admin')->group(function () {

        // ===== KATEGORI =====
        Route::resource('/kategori', AdminKategoriController::class);

        // ===== PRODUK =====
        Route::post('/produk/{produk}/tambah-stok', [AdminProdukController::class, 'tambahStok'])
            ->name('produk.tambah-stok');
        Route::resource('/produk', AdminProdukController::class);

        // ===== USER =====
        Route::resource('/user', AdminUserController::class);
    });

    // ===== TRANSAKSI =====
    Route::get('/transaksi',                   [AdminTransaksiController::class, 'index'])->name('transaksi.index');
    Route::get('/transaksi/create',            [AdminTransaksiController::class, 'create'])->name('transaksi.create');
    Route::post('/transaksi',                  [AdminTransaksiController::class, 'store'])->name('transaksi.store');
    Route::get('/transaksi/{transaksi}/struk', [AdminTransaksiController::class, 'struk'])->name('transaksi.struk');
    Route::get('/transaksi/{transaksi}/edit',  [AdminTransaksiController::class, 'edit'])->name('transaksi.edit');
    Route::put('/transaksi/{transaksi}',       [AdminTransaksiController::class, 'update'])->name('transaksi.update');
    Route::get('/transaksi/{transaksi}',       [AdminTransaksiController::class, 'show'])->name('transaksi.show');
    Route::delete('/transaksi/{transaksi}',    [AdminTransaksiController::class, 'destroy'])->name('transaksi.destroy');
}); 
