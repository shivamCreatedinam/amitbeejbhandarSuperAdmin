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
            $table->id(); // Auto-incrementing primary key
            $table->unsignedBigInteger('product_id'); // Foreign key to products table
            $table->string('variant_name', 100); // Variant name (e.g., "1000ml", "500g", etc.)
            $table->string('unit', 50); // Unit type (e.g., "ml", "g", "kg", etc.)
            $table->integer('total_stock'); // Total stock available
            $table->decimal('mrp', 10, 2); // Maximum retail price
            $table->decimal('selling_price', 10, 2); // Selling price
            $table->decimal('discount', 5, 2); // Discount percentage
            $table->string('image', 255)->nullable(); // Optional: Image of the variant
            $table->timestamps(); // created_at and updated_at fields

            // Foreign key constraint linking variants to products
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
