<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('bao_cao_tai_chinh', function (Blueprint $table) {
            $table->id();
            $table->string('tieu_de');
            $table->enum('loai_bao_cao', ['thang', 'quy', 'sau_thang', 'nam', 'tuy_chinh']);
            $table->bigInteger('quy_tai_chinh_id')->unsigned()->nullable(); // null là tổng hợp
            $table->foreign('quy_tai_chinh_id')->references('id')->on('quy_tai_chinh')->onDelete('set null');

            $table->date('tu_ngay');
            $table->date('den_ngay');

            $table->decimal('tong_thu', 15, 2)->default(0);
            $table->decimal('tong_chi', 15, 2)->default(0);
            $table->decimal('so_du_dau_ky', 15, 2)->default(0);
            $table->decimal('so_du_cuoi_ky', 15, 2)->default(0);

            $table->text('noi_dung_bao_cao')->nullable(); // JSON lưu chi tiết báo cáo
            $table->string('duong_dan_file')->nullable(); // Đường dẫn file PDF/Excel

            $table->bigInteger('nguoi_tao_id')->unsigned();
            $table->foreign('nguoi_tao_id')->references('id')->on('nguoi_dung')->onDelete('cascade');

            $table->boolean('cong_khai')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bao_cao_tai_chinh');
    }
};