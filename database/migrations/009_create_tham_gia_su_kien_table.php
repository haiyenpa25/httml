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
        Schema::create('tham_gia_su_kien', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('su_kien_id');
            $table->unsignedBigInteger('tin_huu_id');
            $table->enum('trang_thai', ['dang_ky', 'co_mat', 'vang_mat'])->default('dang_ky');
            $table->timestamps();

            $table->foreign('su_kien_id')->references('id')->on('su_kien')->onDelete('cascade');
            $table->foreign('tin_huu_id')->references('id')->on('tin_huu')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tham_gia_su_kien');
    }
};