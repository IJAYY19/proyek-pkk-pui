<?php

namespace App\Models;

use App\Models\ActivityLog; // <-- TAMBAHKAN
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth; // <-- TAMBAHKAN

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'image', 'price', 'stock',
    ];

    // TAMBAHKAN METHOD INI
    protected static function booted()
    {
        // Event 'created' akan berjalan SETELAH produk berhasil dibuat
        static::created(function ($product) {
            // Cek apakah ada user yang login (untuk menghindari error saat seeding)
            if (Auth::check()) {
                ActivityLog::create([
                    'user_id' => Auth::id(),
                    'activity' => "Menambahkan produk baru: '{$product->name}'"
                ]);
            }
        });

        // Event 'updated' akan berjalan SETELAH produk berhasil diupdate
        static::updated(function ($product) {
            if (Auth::check()) {
                ActivityLog::create([
                    'user_id' => Auth::id(),
                    'activity' => "Memperbarui produk: '{$product->name}'"
                ]);
            }
        });

        // Event 'deleted' akan berjalan SETELAH produk berhasil dihapus
        static::deleted(function ($product) {
            if (Auth::check()) {
                ActivityLog::create([
                    'user_id' => Auth::id(),
                    'activity' => "Menghapus produk: '{$product->name}'"
                ]);
            }
        });
    }
}