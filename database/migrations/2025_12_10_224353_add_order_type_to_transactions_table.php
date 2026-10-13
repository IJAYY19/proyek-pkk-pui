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
        // Menambahkan kolom order_type (Dine-in / Takeaway)
        $table->string('order_type')->default('Takeaway')->after('customer_class');
        // Menambahkan kolom table_number (Boleh kosong jika Takeaway)
        $table->string('table_number')->nullable()->after('order_type');
    });
}

public function down(): void
{
    Schema::table('transactions', function (Blueprint $table) {
        $table->dropColumn(['order_type', 'table_number']);
    });
}
};
