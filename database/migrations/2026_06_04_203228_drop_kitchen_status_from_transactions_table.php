<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migration: Hapus kolom kitchen_status dari tabel transactions.
     * Fitur dapur/kitchen telah dihapus dari aplikasi.
     */
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('kitchen_status');
        });
    }

    /**
     * Rollback: Kembalikan kolom kitchen_status jika migration di-rollback.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('kitchen_status')->default('pending')->after('status');
        });
    }
};

