<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('giao_dich_tai_chinh', function (Blueprint $table) {
            $table->bigInteger('quy_tai_chinh_id')->unsigned()->nullable()->after('id');
            $table->foreign('quy_tai_chinh_id')->references('id')->on('quy_tai_chinh')->onDelete('set null');

            $table->enum('hinh_thuc', ['dang_hien', 'tai_tro', 'luong', 'hoa_don', 'sua_chua', 'khac'])->nullable()->after('loai');
            $table->enum('phuong_thuc', ['tien_mat', 'chuyen_khoan', 'the', 'khac'])->nullable();

            $table->string('ma_giao_dich')->nullable();
            $table->string('nguoi_nhan')->nullable();
            $table->string('nguoi_duyet_id')->nullable();
            $table->dateTime('ngay_duyet')->nullable();

            $table->enum('trang_thai', ['cho_duyet', 'da_duyet', 'tu_choi', 'hoan_thanh'])->default('hoan_thanh');
            $table->text('ly_do_tu_choi')->nullable();

            $table->bigInteger('chi_dinh_ky_id')->unsigned()->nullable();
            $table->string('duong_dan_hoa_don')->nullable();
        });
    }

    public function down()
    {
        Schema::table('giao_dich_tai_chinh', function (Blueprint $table) {
            $table->dropForeign(['quy_tai_chinh_id']);
            $table->dropColumn([
                'quy_tai_chinh_id',
                'hinh_thuc',
                'phuong_thuc',
                'ma_giao_dich',
                'nguoi_nhan',
                'nguoi_duyet_id',
                'ngay_duyet',
                'trang_thai',
                'ly_do_tu_choi',
                'chi_dinh_ky_id',
                'duong_dan_hoa_don'
            ]);
        });
    }
};