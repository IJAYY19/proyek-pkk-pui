<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Discount;
use Carbon\Carbon;
use Throwable;

class CartController extends Controller
{
    public function index()
{
    $cart = session()->get('cart', []);

    // Hitung Subtotal
    $subtotal = 0;
    foreach($cart as $item) { $subtotal += $item['price'] * $item['quantity']; }

    // Cek Diskon Session
    $discountAmount = 0;
    if(session()->has('discount')) {
        $discountAmount = $subtotal * (session('discount')['percentage'] / 100);
    }
    $finalTotal = $subtotal - $discountAmount;

    // --- TAMBAHAN: Ambil Voucher yang Aktif & Belum Expired ---
    $availableCoupons = \App\Models\Discount::where('is_active', true)
                        ->whereDate('expires_at', '>=', \Carbon\Carbon::today())
                        ->get();

    return view('cart.index', compact('cart', 'subtotal', 'discountAmount', 'finalTotal', 'availableCoupons'));
}

    public function add(Request $request)
    {
        $request->validate(['product_id' => 'required|exists:products,id']);
        $product = Product::findOrFail($request->product_id);
        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity']++;
        } else {
            $cart[$product->id] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price,
                "image" => $product->image
            ];
        }
        session()->put('cart', $cart);
        return redirect()->route('cart.index')->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function remove($productId)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
        }
        return redirect()->route('cart.index')->with('success', 'Produk berhasil dihapus dari keranjang.');
    }

    /**
     * FUNGSI YANG DIPERBARUI UNTUK ALUR "PESAN -> BAYAR DI KASIR"
     */
    public function processCheckout(Request $request)
    {
        // 1. UPDATE VALIDASI
        // Kita tambahkan validasi untuk order_type dan table_number
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_class' => 'required|string|max:50',
            'order_type' => 'required|in:Dine-in,Takeaway', // Harus salah satu dari ini
            'table_number' => 'required_if:order_type,Dine-in|nullable|numeric' // Wajib isi jika Dine-in
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('landing')->with('error', 'Keranjang Anda kosong!');
        }

        DB::beginTransaction();
        try {
            $subtotal = 0;
            $productDetails = [];

            // Validasi stok dan hitung subtotal
            foreach ($cart as $id => $details) {
                $product = Product::find($id);
                if ($product->stock < $details['quantity']) {
                    throw new \Exception('Stok produk ' . $product->name . ' tidak mencukupi.');
                }
                $lineTotal = $product->price * $details['quantity'];
                $subtotal += $lineTotal;

                $productDetails[] = [
                    'product' => $product,
                    'quantity' => $details['quantity'],
                    'subtotal' => $lineTotal,
                ];
            }

            // --- LOGIKA DISKON ---
            $discountAmount = 0;
            $discountCode = null;

            if (session()->has('discount')) {
                $discountData = session('discount');
                $discountCode = $discountData['code'];
                $percentage = $discountData['percentage'];

                $discountAmount = $subtotal * ($percentage / 100);
            }

            $finalTotal = $subtotal - $discountAmount;
            if ($finalTotal < 0) $finalTotal = 0;
            // --- AKHIR LOGIKA DISKON ---

            // 2. UPDATE SIMPAN TRANSAKSI
            // Masukkan data order_type dan table_number ke database
            $transaction = Transaction::create([
                'user_id' => null,
                'customer_name' => $request->customer_name,
                'customer_class' => $request->customer_class,

                // DATA BARU: TIPE PESANAN
                'order_type' => $request->order_type,
                // Simpan nomor meja jika Dine-in, jika Takeaway set null
                'table_number' => $request->order_type == 'Dine-in' ? $request->table_number : null,

                'total_amount' => $finalTotal,
                'discount_amount' => $discountAmount,
                'discount_code' => $discountCode,

                'payment_method' => 'Belum Dibayar', // Default karena bayar di kasir
                'status' => 'pending',
            ]);

            // Simpan detail transaksi
            foreach ($productDetails as $detail) {
                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $detail['product']->id,
                    'quantity' => $detail['quantity'],
                    'subtotal' => $detail['subtotal'],
                ]);

                // CATATAN: Kita TIDAK mengurangi stok di sini
                // Stok akan dikurangi nanti saat Kasir klik "Selesaikan Pembayaran"
            }

            DB::commit();

            // Bersihkan session
            session()->forget('cart');
            session()->forget('discount');

            return redirect()->route('landing')->with('success', 'Pesanan berhasil dibuat! Silakan menuju kasir untuk pembayaran.');

        } catch (Throwable $e) {
            DB::rollBack();
            return redirect()->route('cart.index')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required|numeric',
            'quantity' => 'required|numeric|min:1',
        ]);

        $cart = session()->get('cart', []);

        if (isset($cart[$request->product_id])) {
            $cart[$request->product_id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
            return redirect()->route('cart.index')->with('success', 'Kuantitas berhasil diperbarui.');
        }

        return redirect()->route('cart.index')->with('error', 'Produk tidak ditemukan di keranjang.');
    }

    public function applyDiscount(Request $request)
{
    $request->validate(['code' => 'required|string']);

    $discount = Discount::where('code', $request->code)
                        ->where('is_active', true)
                        ->whereDate('expires_at', '>=', Carbon::today())
                        ->first();

    if (!$discount) {
        return back()->with('error', 'Kode promo tidak valid atau kadaluarsa.');
    }

    // --- TAMBAHAN: Cek Minimal Belanja ---
    $cart = session()->get('cart', []);
    $subtotal = 0;
    foreach($cart as $item) { $subtotal += $item['price'] * $item['quantity']; }

    if ($subtotal < $discount->min_purchase) {
        return back()->with('error', 'Maaf, minimal belanja untuk kode ini adalah Rp ' . number_format($discount->min_purchase, 0, ',', '.'));
    }
    // -------------------------------------

    session()->put('discount', [
        'code' => $discount->code,
        'percentage' => $discount->percentage
    ]);

    return back()->with('success', 'Kode promo berhasil dipasang!');
}

public function removeDiscount()
    {
        session()->forget('discount'); // Hapus session diskon
        return back()->with('success', 'Kode promo berhasil dilepas.');
    }
}
