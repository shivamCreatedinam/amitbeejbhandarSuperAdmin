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
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("product_id");
            $table->string("variant_name");
            $table->string("total_stock")->nullable();
            $table->double("mrp", 10, 2)->default(0.0);  // Changed to double(10,2)
            $table->double("selling_price", 10, 2)->default(0.0);  // Changed to double(10,2)
            $table->string("discount")->nullable();
            $table->string("image")->nullable();
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
