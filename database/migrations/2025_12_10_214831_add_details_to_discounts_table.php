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
    Schema::table('discounts', function (Blueprint $table) {
        $table->string('description')->after('code')->nullable(); // Nama Promo
        $table->integer('min_purchase')->default(0)->after('percentage'); // Syarat Min. Belanja
    });
}

public function down(): void
{
    Schema::table('discounts', function (Blueprint $table) {
        $table->dropColumn(['description', 'min_purchase']);
    });
}
};
