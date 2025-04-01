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
        Schema::create('tai_lieu', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tieu_de');
            $table->string('duong_dan_tai_lieu');
            $table->string('danh_muc', 100);
            $table->unsignedBigInteger('nguoi_tai_len_id');
            $table->timestamps();

            $table->foreign('nguoi_tai_len_id')->references('id')->on('tin_huu')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tai_lieu');
    }
};