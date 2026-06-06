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
        Schema::table('auctions', function (Blueprint $table) {
            // Adding foreign key for current_highest_bid in auctions table
            $table->foreignUuid('current_highest_bid')->nullable()->constrained('bids')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('auctions', function (Blueprint $table) {
            // Dropping foreign key for current_highest_bid in auctions table
            $table->dropForeign(['current_highest_bid']);
            $table->dropColumn('current_highest_bid');
        });
    }
};
