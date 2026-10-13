<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;
use App\Events\TransactionActivity;

class TransactionController extends Controller
{
    public function create()
    {
        $products = Product::where('stock', '>', 0)->orderBy('name')->get();
        return view('kasir.transaction.create', compact('products'));
    }

    public function store(Request $request)
    {
        // 1. Validasi input (Ditambahkan penanganan payment_amount & change_amount)
        $request->validate([
            'cart_data' => 'required|json',
            'payment_method' => 'required|string',
            'payment_amount' => 'nullable|numeric', // Tambah ini
            'change_amount' => 'nullable|numeric',   // Tambah ini
            // customer_name dan customer_class opsional
        ]);

        $cart = json_decode($request->cart_data, true);

        if (empty($cart)) {
            return back()->with('error', 'Keranjang tidak boleh kosong!');
        }

        DB::beginTransaction();
        try {
            $totalPrice = 0;
            $productDetails = [];

            // 2. Loop cek stok dan hitung total
            foreach ($cart as $item) {
                $product = Product::find($item['id']);
                if ($product->stock < $item['quantity']) {
                    throw new \Exception('Stok produk ' . $product->name . ' tidak mencukupi.');
                }
                $subtotal = $product->price * $item['quantity'];
                $totalPrice += $subtotal;
                $productDetails[] = [
                    'product' => $product,
                    'quantity' => $item['quantity'],
                    'subtotal' => $subtotal,
                ];
            }

            // 3. Simpan Transaksi dengan status COMPLETED (Ditambahkan field bayar & kembali)
            $transaction = Transaction::create([
                'user_id' => Auth::id(), // Kasir yang login
                'customer_name' => $request->customer_name ?? 'Pelanggan Umum',
                'customer_class' => $request->customer_class,
                'total_amount' => $totalPrice,
                'payment_method' => $request->payment_method, // Data lengkap dari JS (misal: Kartu Debit - BCA)
                'status' => 'completed', // <--- KUNCI: Langsung completed agar tidak masuk pending
                'payment_amount' => $request->payment_amount ?? $totalPrice, // Tambah ini (fallback ke total jika non-tunai)
                'change_amount' => $request->change_amount ?? 0,             // Tambah ini (fallback ke 0)
            ]);

            // 4. Simpan detail & Kurangi Stok
            foreach ($productDetails as $detail) {
                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $detail['product']->id,
                    'quantity' => $detail['quantity'],
                    'subtotal' => $detail['subtotal'],
                ]);

                // Kurangi stok segera
                $detail['product']->decrement('stock', $detail['quantity']);
            }

            DB::commit();

            // 5. Redirect ke halaman yang sama dengan sinyal cetak struk
            return redirect()->route('kasir.transaction.create')
                ->with('success', 'Transaksi berhasil disimpan!')
                ->with('print_struk', $transaction->id); // Trigger popup struk

        } catch (Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function laporan()
    {
        // Ambil ID kasir yang sedang login
        $kasirId = Auth::id();

        // Ambil data transaksi HANYA untuk kasir yang sedang login
        $transactions = Transaction::with('details.product')
            ->where('user_id', $kasirId)
            ->where('status', 'completed')
            ->latest()
            ->paginate(10);

        return view('kasir.laporan.index', compact('transactions'));
    }

    // Method untuk menampilkan daftar pesanan yang masih pending
    public function daftarPesanan()
    {
        $pendingTransactions = Transaction::with('details.product')
            ->where('status', 'pending')
            ->latest()
            ->get();
        return view('kasir.pesanan.index', compact('pendingTransactions'));
    }

    // Method untuk menyelesaikan pembayaran
    public function selesaikanPembayaran(Request $request, Transaction $transaction)
    {
        // Validasi input (Ditambahkan penanganan payment_amount & change_amount)
        $request->validate([
            'payment_method' => 'required|string',
            'payment_amount' => 'nullable|numeric', // Tambah ini
            'change_amount' => 'nullable|numeric',   // Tambah ini
        ]);

        DB::beginTransaction();
        try {
            // Validasi stok sekali lagi sebelum pembayaran
            foreach ($transaction->details as $detail) {
                if ($detail->product->stock < $detail->quantity) {
                    throw new \Exception('Stok produk ' . $detail->product->name . ' tidak mencukupi.');
                }
                // Kurangi stok
                $detail->product->update(['stock' => $detail->product->stock - $detail->quantity]);
            }

            // Update status transaksi menjadi 'completed' (Ditambahkan field bayar & kembali)
            $transaction->update([
                'status' => 'completed',
                'payment_method' => $request->payment_method,
                'user_id' => Auth::id(), // Catat kasir yang menyelesaikan
                'payment_amount' => $request->payment_amount ?? $transaction->total_amount, // Tambah ini
                'change_amount' => $request->change_amount ?? 0,                             // Tambah ini
            ]);

            DB::commit();
            return redirect()->route('kasir.pesanan.index')
                ->with('success', 'Pembayaran untuk transaksi #' . $transaction->id . ' berhasil diselesaikan.')
                ->with('print_struk', $transaction->id);
        } catch (Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function cetakStruk(Transaction $transaction)
    {
        // Pastikan memuat relasi yang dibutuhkan
        $transaction->load(['details.product', 'user']);
        return view('struk', compact('transaction'));
    }
}
