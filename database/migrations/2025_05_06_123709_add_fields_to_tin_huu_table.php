<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('tin_huu', function (Blueprint $table) {
            $table->date('ngay_sinh_hoat_voi_hoi_thanh')->nullable()->after('ngay_tin_chua');
            $table->date('ngay_nhan_bap_tem')->nullable()->after('ngay_sinh_hoat_voi_hoi_thanh');
            $table->boolean('hoan_thanh_bap_tem')->default(false)->after('ngay_nhan_bap_tem');
            $table->string('noi_xuat_than')->nullable()->after('hoan_thanh_bap_tem');
            $table->string('cccd', 12)->nullable()->after('noi_xuat_than');
            $table->string('ma_dinh_danh_tinh')->nullable()->after('cccd');
        });
    }

    public function down()
    {
        Schema::table('tin_huu', function (Blueprint $table) {
            $table->dropColumn([
                'ngay_sinh_hoat_voi_hoi_thanh',
                'ngay_nhan_bap_tem',
                'hoan_thanh_bap_tem',
                'noi_xuat_than',
                'cccd',
                'ma_dinh_danh_tinh'
            ]);
        });
    }
};
