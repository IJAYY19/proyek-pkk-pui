<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            // Ubah tipe data string dan perpanjang (default 255) agar bisa menampung detail
            $table->string('payment_method', 100)->change();
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            // Kembalikan ke keadaan semula jika diperlukan
            $table->string('payment_method')->change();
        });
    }
};
