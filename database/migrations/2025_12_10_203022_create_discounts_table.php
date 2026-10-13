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
        Schema::create('discounts', function (Blueprint $table) {
        $table->id();
        $table->string('code')->unique(); // Kode Promo (misal: MIE10)
        $table->integer('percentage'); // Besar diskon dalam persen (misal: 10)
        $table->date('expires_at'); // Tanggal kadaluarsa
        $table->boolean('is_active')->default(true); // Status aktif/tidak
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discounts');
    }
};
