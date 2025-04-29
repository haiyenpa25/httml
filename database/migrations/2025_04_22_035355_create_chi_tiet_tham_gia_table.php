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
        // Nếu bảng đã tồn tại, không cần tạo nữa
        if (Schema::hasTable('chi_tiet_tham_gia')) {
            return;
        }

        Schema::create('chi_tiet_tham_gia', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('buoi_nhom_id');
            $table->unsignedBigInteger('tin_huu_id');
            $table->enum('trang_thai', ['co_mat', 'vang_mat', 'vang_co_phep'])->default('co_mat');
            $table->text('ghi_chu')->nullable();
            $table->timestamps();

            // Khóa ngoại
            $table->foreign('buoi_nhom_id')->references('id')->on('buoi_nhom')->onDelete('cascade');
            $table->foreign('tin_huu_id')->references('id')->on('tin_huu')->onDelete('cascade');

            // Bảo đảm không có dữ liệu trùng lặp
            $table->unique(['buoi_nhom_id', 'tin_huu_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chi_tiet_tham_gia');
    }
};
