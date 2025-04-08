<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('buoi_nhom_nhiem_vu', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('buoi_nhom_id');
            $table->unsignedBigInteger('nhiem_vu_id');
            $table->unsignedTinyInteger('vi_tri');
            $table->unsignedBigInteger('tin_huu_id')->nullable();
            $table->text('ghi_chu')->nullable();
            $table->timestamps();

            $table->foreign('buoi_nhom_id')->references('id')->on('buoi_nhom')->onDelete('cascade');
            $table->foreign('nhiem_vu_id')->references('id')->on('nhiem_vu')->onDelete('restrict');
            $table->foreign('tin_huu_id')->references('id')->on('tin_huu')->onDelete('set null');
            $table->index(['buoi_nhom_id', 'nhiem_vu_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('buoi_nhom_nhiem_vu');
    }
};
