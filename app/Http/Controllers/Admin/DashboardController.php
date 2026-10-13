<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon; // Untuk tanggal hari ini
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Data Statistik
        $today = Carbon::today();

        $pendapatanHariIni = Transaction::whereDate('created_at', $today)
            ->where('status', 'completed') // Hanya yang sudah bayar
            ->sum('total_amount');

        $transaksiHariIni = Transaction::whereDate('created_at', $today)
            ->where('status', 'completed')
            ->count();

        $totalProduk = Product::count();
        $totalUser = User::count();

        // 2. Produk dengan Stok Menipis (Kurang dari 5)
        $lowStockProducts = Product::where('stock', '<', 5)->get();

        // 3. 5 Transaksi Terbaru
        $recentTransactions = Transaction::with('user')
            ->where('status', 'completed')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'pendapatanHariIni',
            'transaksiHariIni',
            'totalProduk',
            'totalUser',
            'lowStockProducts',
            'recentTransactions'
        ));
    }
}
