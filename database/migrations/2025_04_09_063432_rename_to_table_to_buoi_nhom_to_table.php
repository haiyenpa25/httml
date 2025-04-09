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
        Schema::rename('to', 'buoi_nhom_to');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::rename('buoi_nhom_to', 'to');
    }
};
