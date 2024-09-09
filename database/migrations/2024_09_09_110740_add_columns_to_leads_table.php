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
        Schema::table('leads', function (Blueprint $table) {
             // 1. Add PAN Number column
             $table->string('pan_number')->nullable()->after('gst_number');

             // 2. Add order_status column with enum values: pending, accept, cancel
             $table->enum('order_status', ['pending', 'accept', 'cancel'])->default('pending')->after('remarks');

             // 3. Add cancellation_reason column as longText
             $table->longText('cancellation_reason')->nullable()->after('order_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->dropColumn('pan_number');
            $table->dropColumn('order_status');
            $table->dropColumn('cancellation_reason');
        });
    }
};
