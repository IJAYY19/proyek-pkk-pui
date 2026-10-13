<?php

namespace App\Models;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'customer_name',
        'customer_class',
        'order_type',
        'table_number',
        'total_amount',
        'discount_amount',
        'discount_code',
        'payment_method',
        'status',
        'payment_amount',
        'change_amount',
    ];

    /**
     * Mendefinisikan relasi "belongsTo" ke model User.
     * Ini menghubungkan transaksi ke kasir yang membuatnya.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Mendefinisikan relasi "hasMany" ke model TransactionDetail.
     * Ini menghubungkan satu transaksi ke banyak item detailnya.
     */
    public function details()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    protected static function booted()
    {
        // 1. Log saat Pesanan DIBUAT (Sudah ada sebelumnya)
        static::created(function ($transaction) {
            $user = Auth::user();
            if ($user) {
                $activity = "Kasir '{$user->name}' membuat transaksi baru #{$transaction->id}.";
                $userId = $user->id;
            } else {
                $activity = "Customer '{$transaction->customer_name}' membuat pesanan baru #{$transaction->id}.";
                $userId = null;
            }

            ActivityLog::create([
                'user_id' => $userId,
                'activity' => $activity
            ]);
        });

        // 2. Log saat Status Pembayaran berubah menjadi 'completed'
        static::updated(function ($transaction) {
            $user = Auth::user();
            $actorName = $user ? $user->name : 'System';
            $userId = $user ? $user->id : null;

            // Cek apakah Status Pembayaran berubah menjadi Completed?
            if ($transaction->isDirty('status') && $transaction->status == 'completed') {
                ActivityLog::create([
                    'user_id' => $userId,
                    'activity' => "Kasir '{$actorName}' menyelesaikan pembayaran untuk Order #{$transaction->id}."
                ]);
            }
        });
    }
}
