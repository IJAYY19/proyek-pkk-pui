<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Role; // <-- PENTING: Import model Role

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username', // <-- Ganti 'email' menjadi 'username'
        'password',
        'role_id',  // <-- Tambahkan role_id agar bisa diisi oleh Seeder
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        // Hapus 'email_verified_at' karena kita tidak memakainya lagi
        return [
            'password' => 'hashed',
        ];
    }

    /**
     * Mendefinisikan relasi ke model Role.
     * Ini adalah "jembatan" yang menghubungkan User ke Role-nya.
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
