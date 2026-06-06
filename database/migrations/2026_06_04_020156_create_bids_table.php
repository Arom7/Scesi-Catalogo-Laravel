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
        Schema::create('bids', function (Blueprint $table) {
            // Database schema for bids
            $table->uuid('id')->primary();
            $table->decimal('amount', 10, 2);
            // Foreign keys to users and auctions
            $table->foreignUuid('user_id')->constrained()->onDelete('cascade');
            $table->foreignUuid('auction_id')->constrained('auctions')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bids');
    }
};
