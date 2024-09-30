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
            $table->unsignedBigInteger('product_id');
            $table->string('variant_name', 100); // Variant name (e.g., "1000ml", "500g", etc.)
            $table->string('quantity', 50)->nullable();
            $table->string('unit', 50); // Unit type (e.g., "ml", "g", "kg", etc.)
            $table->integer('total_stock')->nullable(); 
            $table->integer('packing')->nullable(); 
            $table->decimal('mrp', 10, 2); 
            $table->decimal('selling_price', 10, 2);
            $table->decimal('discount', 5, 2); 
            $table->string('image', 255)->nullable(); 
            $table->timestamps(); 

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
