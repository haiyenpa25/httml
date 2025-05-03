<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('chi_dinh_ky', function (Blueprint $table) {
            $table->id();
            $table->string('ten');
            $table->text('mo_ta')->nullable();
            $table->decimal('so_tien', 15, 2);
            $table->bigInteger('quy_tai_chinh_id')->unsigned();
            $table->foreign('quy_tai_chinh_id')->references('id')->on('quy_tai_chinh')->onDelete('cascade');

            $table->enum('tan_suat', ['hang_thang', 'hang_quy', 'nua_nam', 'hang_nam']);
            $table->integer('ngay_thanh_toan')->nullable(); // Ngày trong tháng
            $table->integer('thang_thanh_toan')->nullable(); // Tháng trong năm

            $table->date('ngay_bat_dau');
            $table->date('ngay_ket_thuc')->nullable();

            $table->string('nguoi_nhan')->nullable();
            $table->text('thong_tin_thanh_toan')->nullable();

            $table->boolean('tu_dong_tao')->default(false); // Tự động tạo giao dịch
            $table->integer('nhac_truoc_ngay')->default(3); // Số ngày nhắc trước hạn

            $table->enum('trang_thai', ['hoat_dong', 'tam_dung', 'huy_bo'])->default('hoat_dong');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('chi_dinh_ky');
    }
};