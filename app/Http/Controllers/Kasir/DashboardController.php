<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $today = Carbon::today();

        // 1. Omset Kasir INI Hari Ini (Hanya yang status completed)
        $omsetHariIni = Transaction::where('user_id', $userId)
            ->whereDate('created_at', $today)
            ->where('status', 'completed')
            ->sum('total_amount');

        // 2. Jumlah Transaksi Kasir INI Hari Ini
        $transaksiHariIni = Transaction::where('user_id', $userId)
            ->whereDate('created_at', $today)
            ->where('status', 'completed')
            ->count();

        // 3. Pesanan Pending (Global, karena semua kasir harus tahu ada antrean)
        $pesananPending = Transaction::where('status', 'pending')->count();

        // 4. Produk Aktif (Menu yang tersedia)
        $totalMenu = Product::count();

        // 5. 5 Transaksi Terakhir oleh Kasir INI
        $recentTransactions = Transaction::where('user_id', $userId)
            ->where('status', 'completed')
            ->latest()
            ->take(5)
            ->get();

        return view('kasir.dashboard', compact(
            'omsetHariIni',
            'transaksiHariIni',
            'pesananPending',
            'totalMenu',
            'recentTransactions'
        ));
    }
}
