<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nhiem_vu', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ten_nhiem_vu', 50);
            $table->text('mo_ta')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nhiem_vu');
    }
};
