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
        Schema::create('product_images', function (Blueprint $table) {
            // Schema for product_images table
            $table->uuid('id')->primary();
            $table->string('image_url');
            $table->boolean('is_main')->default(false);
            // Foreign key to products table
            $table->foreignUuid('product_id')->constrained()->onDelete('cascade');
            // Timestamps for created_at and updated_at
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_images');
    }
};
