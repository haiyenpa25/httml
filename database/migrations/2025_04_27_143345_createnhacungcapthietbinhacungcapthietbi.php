<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('thiet_bi', function (Blueprint $table) {
            // Thêm các cột mới
            $table->string('vi_tri_hien_tai', 255)->nullable()->after('nha_cung_cap_id');
            $table->date('thoi_gian_bao_hanh')->nullable()->after('vi_tri_hien_tai');
            $table->integer('chu_ky_bao_tri')->nullable()->comment('Số ngày giữa các lần bảo trì')->after('thoi_gian_bao_hanh');
            $table->date('ngay_het_han_su_dung')->nullable()->after('chu_ky_bao_tri');
            $table->string('ma_tai_san')->nullable()->after('ngay_het_han_su_dung');
            $table->string('hinh_anh')->nullable()->after('ma_tai_san');

            // Thêm khóa ngoại
            $table->foreign('nha_cung_cap_id')->references('id')->on('nha_cung_cap')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('thiet_bi', function (Blueprint $table) {
            $table->dropForeign(['nha_cung_cap_id']);
            $table->dropColumn([
                'vi_tri_hien_tai',
                'thoi_gian_bao_hanh',
                'chu_ky_bao_tri',
                'ngay_het_han_su_dung',
                'ma_tai_san',
                'hinh_anh'
            ]);
        });
    }
};