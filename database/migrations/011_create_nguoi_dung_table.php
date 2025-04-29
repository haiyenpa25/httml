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
        Schema::create('nguoi_dung', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('tin_huu_id');
            $table->string('email')->unique();
            $table->string('mat_khau');
            $table->enum('vai_tro', ['quan_tri', 'truong_ban', 'thanh_vien'])->default('thanh_vien');
            $table->timestamps();

            $table->foreign('tin_huu_id')->references('id')->on('tin_huu')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nguoi_dung');
    }
};