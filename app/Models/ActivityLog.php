<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    // TAMBAHKAN PROPERTI INI
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'activity',
    ];

    // Tambahkan relasi ini untuk ke depannya
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
