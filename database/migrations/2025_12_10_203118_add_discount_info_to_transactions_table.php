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
        // Simpan nominal diskon (Rp)
        $table->integer('discount_amount')->default(0)->after('total_amount');
        // Simpan kode yang dipakai (opsional, buat history)
        $table->string('discount_code')->nullable()->after('discount_amount');
    });
}

public function down(): void
{
    Schema::table('transactions', function (Blueprint $table) {
        $table->dropColumn(['discount_amount', 'discount_code']);
    });
}
};
