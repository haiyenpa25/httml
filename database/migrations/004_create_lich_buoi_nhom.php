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
        Schema::dropIfExists('lich_buoi_nhom'); // Drop bảng cũ

        Schema::create('buoi_nhom_lich', function (Blueprint $table) { // Tạo bảng mới với tên 'buoi_nhom_lich'
            $table->bigIncrements('id');
            $table->string('ten', 100);
            $table->unsignedBigInteger('buoi_nhom_loai_id'); // Khóa ngoại cho bảng 'buoi_nhom_loai'
            $table->unsignedBigInteger('ban_nganh_id')->nullable();
            $table->enum('thu', ['thu_2', 'thu_3', 'thu_4', 'thu_5', 'thu_6', 'thu_7', 'chu_nhat']);
            $table->time('gio_bat_dau');
            $table->time('gio_ket_thuc');
            $table->enum('tan_suat', ['hang_tuan', 'tuan_cuoi_thang']);
            $table->text('dia_diem');
            $table->text('mo_ta')->nullable();
            $table->timestamps();

            $table->foreign('ban_nganh_id')->references('id')->on('ban_nganh')->onDelete('set null');
            $table->foreign('buoi_nhom_loai_id')->references('id')->on('buoi_nhom_loai')->onDelete('restrict');
            $table->index('ban_nganh_id');
            $table->index('buoi_nhom_loai_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buoi_nhom_lich'); // Drop bảng mới nếu rollback
        Schema::create('lich_buoi_nhom', function (Blueprint $table) { // Tạo lại bảng cũ nếu rollback
            $table->bigIncrements('id');
            $table->string('ten', 100);
            $table->enum('loai', ['hoi_thanh', 'ban_nganh', 'truyen_giang']);
            $table->unsignedBigInteger('ban_nganh_id')->nullable();
            $table->enum('thu', ['thu_2', 'thu_3', 'thu_4', 'thu_5', 'thu_6', 'thu_7', 'chu_nhat']);
            $table->time('gio_bat_dau');
            $table->time('gio_ket_thuc');
            $table->enum('tan_suat', ['hang_tuan', 'tuan_cuoi_thang']);
            $table->text('dia_diem');
            $table->text('mo_ta')->nullable();
            $table->timestamps();

            $table->foreign('ban_nganh_id')->references('id')->on('ban_nganh')->onDelete('set null');
            $table->index('ban_nganh_id');
        });
    }
};
