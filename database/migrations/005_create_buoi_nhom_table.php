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
        Schema::create('buoi_nhom', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('lich_buoi_nhom_id');
            $table->date('ngay_dien_ra');
            $table->time('gio_bat_dau');
            $table->time('gio_ket_thuc');
            $table->text('dia_diem');
            $table->integer('so_luong_tham_gia')->default(0);
            $table->text('ghi_chu')->nullable();
            $table->enum('trang_thai', ['da_dien_ra', 'sap_dien_ra', 'huy'])->default('sap_dien_ra');
            $table->timestamps();

            $table->foreign('lich_buoi_nhom_id')->references('id')->on('lich_buoi_nhom')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buoi_nhom');
    }
};