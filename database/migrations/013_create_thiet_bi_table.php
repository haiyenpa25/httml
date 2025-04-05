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
        Schema::create('thiet_bi', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ten');
            $table->enum('loai', ['nhac_cu', 'anh_sang', 'am_thanh', 'hinh_anh', 'khac']);
            $table->enum('tinh_trang', ['tot', 'hong', 'dang_sua'])->default('tot');
            $table->date('ngay_mua')->nullable();
            $table->unsignedBigInteger('nguoi_quan_ly_id')->nullable();
            $table->unsignedBigInteger('id_ban')->nullable();
            $table->text('vi_tri')->nullable();
            $table->text('mo_ta')->nullable();
            $table->timestamps();

            $table->foreign('nguoi_quan_ly_id')->references('id')->on('tin_huu')->onDelete('set null');
            $table->foreign('id_ban')->references('id')->on('ban_nganh')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('thiet_bi');
    }
};