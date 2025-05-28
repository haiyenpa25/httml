<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('lop_hoc', function (Blueprint $table) {
            $table->id();
            $table->string('ten_lop');
            $table->enum('loai_lop', ['bap_tem', 'thanh_nien', 'trung_lao', 'khac']);
            $table->dateTime('thoi_gian_bat_dau')->nullable();
            $table->dateTime('thoi_gian_ket_thuc')->nullable();
            $table->enum('tan_suat', ['co_dinh', 'linh_hoat']);
            $table->text('dia_diem');
            $table->text('mo_ta')->nullable();
            $table->timestamps();
        });

        Schema::create('lop_hoc_tin_huu', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lop_hoc_id')->constrained()->onDelete('cascade');
            $table->foreignId('tin_huu_id')->constrained()->onDelete('cascade');
            $table->enum('vai_tro', ['giao_vien', 'hoc_vien']);
            $table->timestamps();
            $table->unique(['lop_hoc_id', 'tin_huu_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('lop_hoc_tin_huu');
        Schema::dropIfExists('lop_hoc');
    }
};
