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
        Schema::table('cinema_halls', function (Blueprint $table) {
            $table->index('rows');
            $table->index('seats_per_row');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cinema_halls', function (Blueprint $table) {
            $table->dropIndex('rows');
            $table->dropIndex('seats_per_row');
        });
    }
};
