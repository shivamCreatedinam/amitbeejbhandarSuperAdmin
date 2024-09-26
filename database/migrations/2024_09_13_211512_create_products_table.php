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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("category_id");
            $table->unsignedBigInteger("sub_category_id");
            $table->unsignedBigInteger("brand_id");
            $table->text("image")->nullable();
            $table->string("product_name")->nullable();
            // $table->string("total_stock")->nullable();
            // $table->double("mrp", 10, 2)->default(0.0);  // Changed to double(10,2)
            // $table->double("selling_price", 10, 2)->default(0.0);  // Changed to double(10,2)
            // $table->string("discount")->nullable();
            $table->text("short_desc")->nullable();
            $table->longText("long_desc")->nullable();
            $table->longText("features")->nullable();
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');
            $table->foreign('sub_category_id')->references('id')->on('sub_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
