<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('buoi_nhom', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->foreignId('lich_buoi_nhom_id')->constrained('lich_buoi_nhom')->onDelete('restrict');
            $table->date('ngay_dien_ra');
            $table->time('gio_bat_dau');
            $table->time('gio_ket_thuc');
            $table->text('dia_diem');

            $table->string('chu_de', 255)->nullable();
            $table->string('kinh_thanh', 100)->nullable();
            $table->string('cau_goc', 255)->nullable();

            $table->unsignedTinyInteger('so_luong_trung_lao')->default(0);
            $table->unsignedTinyInteger('so_luong_thanh_trang')->default(0);
            $table->unsignedTinyInteger('so_luong_thanh_nien')->default(0);
            $table->unsignedTinyInteger('so_luong_thieu_nhi_au')->default(0);
            $table->unsignedTinyInteger('so_luong_tin_huu_khac')->default(0);
            $table->unsignedSmallInteger('so_luong_tin_huu')->default(0);
            $table->unsignedSmallInteger('so_luong_than_huu')->default(0);
            $table->unsignedTinyInteger('so_nguoi_tin_chua')->default(0);

            $table->foreignId('id_to')->nullable()->constrained('to')->onDelete('set null');
            $table->foreignId('id_tin_huu_hdct')->nullable()->constrained('tin_huu')->onDelete('set null');
            $table->foreignId('id_tin_huu_do_kt')->nullable()->constrained('tin_huu')->onDelete('set null');
            $table->foreignId('dien_gia_id')->nullable()->constrained('dien_gia')->onDelete('set null');

            $table->enum('trang_thai', ['da_dien_ra', 'sap_dien_ra', 'huy'])->default('sap_dien_ra');
            $table->text('ghi_chu')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('buoi_nhom');
    }
};
