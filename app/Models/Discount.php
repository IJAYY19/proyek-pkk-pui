<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth; // <-- PENTING: Import Auth
use App\Models\ActivityLog;          // <-- PENTING: Import ActivityLog

class Discount extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'percentage',
        'expires_at',
        'is_active',
        'description',
        'min_purchase'
    ];

    /**
     * The "booted" method of the model.
     * Logika otomatis mencatat aktivitas saat Create/Update/Delete
     */
    protected static function booted()
    {
        // 1. Saat Diskon Dibuat
        static::created(function ($discount) {
            if (Auth::check()) {
                ActivityLog::create([
                    'user_id' => Auth::id(),
                    'activity' => "Menambahkan kode diskon baru: '{$discount->code}' ({$discount->percentage}%)"
                ]);
            }
        });

        // 2. Saat Diskon Diupdate (Optional, tapi bagus ada)
        static::updated(function ($discount) {
            if (Auth::check()) {
                ActivityLog::create([
                    'user_id' => Auth::id(),
                    'activity' => "Memperbarui kode diskon: '{$discount->code}'"
                ]);
            }
        });

        // 3. Saat Diskon Dihapus
        static::deleted(function ($discount) {
            if (Auth::check()) {
                ActivityLog::create([
                    'user_id' => Auth::id(),
                    'activity' => "Menghapus kode diskon: '{$discount->code}'"
                ]);
            }
        });
    }
}
