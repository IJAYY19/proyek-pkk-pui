<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Kasir\TransactionController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Kasir\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// == HALAMAN PUBLIK ==
Route::get('/', [LandingController::class, 'index'])->name('landing');

// == GUEST CHECKOUT / CART ROUTES ==
Route::post('/chat-ai', [\App\Http\Controllers\ChatAIController::class, 'handleChat'])->name('chat.ai');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/remove/{productId}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/checkout', [CartController::class, 'processCheckout'])->name('cart.checkout');
Route::post('/cart/apply-discount', [CartController::class, 'applyDiscount'])->name('cart.apply_discount');
Route::delete('/cart/remove-discount', [CartController::class, 'removeDiscount'])->name('cart.remove_discount');


// == PROSES OTENTIKASI ==
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');


// == HALAMAN TERPROTEKSI ==
Route::middleware(['auth'])->group(function () {

    Route::get('/transaksi/{transaction}/struk', [TransactionController::class, 'cetakStruk'])->name('transaksi.struk');

    // Route untuk Admin
    Route::middleware(\App\Http\Middleware\EnsureUserHasRole::class . ':admin')
        ->prefix('admin')->name('admin.')->group(function () { // <-- Tambahkan name('admin.')

            // Arahkan ke view dashboard
            Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
            Route::resource('discounts', \App\Http\Controllers\Admin\DiscountController::class);

            // Tambahkan Resource Controller untuk Produk
            Route::resource('products', ProductController::class);
            // Route untuk Laporan
            Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
            Route::get('logs', [ReportController::class, 'logs'])->name('logs.index');
        });

    // Route untuk Kasir
    Route::middleware(\App\Http\Middleware\EnsureUserHasRole::class . ':kasir')
        ->prefix('kasir')->name('kasir.')->group(function () {

            // --- PERUBAHAN DI SINI ---
            // Hapus redirect function, ganti dengan Controller
            Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
            // -------------------------

            // Route untuk menampilkan halaman transaksi
            Route::get('/transaksi', [TransactionController::class, 'create'])->name('transaction.create');
            // Route untuk menyimpan transaksi
            Route::post('/transaksi', [TransactionController::class, 'store'])->name('transaction.store');

            // Route Laporan
            Route::get('laporan', [TransactionController::class, 'laporan'])->name('laporan.index');

            // Route Pesanan Masuk
            Route::get('pesanan', [TransactionController::class, 'daftarPesanan'])->name('pesanan.index');
            Route::post('pesanan/{transaction}/selesaikan', [TransactionController::class, 'selesaikanPembayaran'])->name('pesanan.selesaikan');

            // Route Cetak Struk (jika belum ada di luar grup ini)
            Route::get('/transaksi/{transaction}/struk', [TransactionController::class, 'cetakStruk'])->name('transaksi.struk');
        });
});
