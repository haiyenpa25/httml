<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('thong_bao_tai_chinh', function (Blueprint $table) {
            $table->id();
            $table->string('tieu_de');
            $table->text('noi_dung');
            $table->enum('loai', ['giao_dich_moi', 'yeu_cau_duyet', 'da_duyet', 'tu_choi', 'nhac_chi_dinh_ky', 'canh_bao_so_du', 'khac']);

            $table->bigInteger('nguoi_nhan_id')->unsigned();
            $table->foreign('nguoi_nhan_id')->references('id')->on('nguoi_dung')->onDelete('cascade');

            $table->string('reference_type')->nullable(); // Polymorphic relationship
            $table->bigInteger('reference_id')->nullable();

            $table->boolean('da_doc')->default(false);
            $table->timestamp('ngay_doc')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('thong_bao_tai_chinh');
    }
};