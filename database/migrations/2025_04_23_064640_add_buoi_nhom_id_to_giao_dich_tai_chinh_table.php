<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('giao_dich_tai_chinh', function (Blueprint $table) {
            // Thêm cột buoi_nhom_id
            $table->unsignedBigInteger('buoi_nhom_id')->nullable()->after('ban_nganh_id');

            // Tạo khóa ngoại
            $table->foreign('buoi_nhom_id')
                ->references('id')
                ->on('buoi_nhom')
                ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('giao_dich_tai_chinh', function (Blueprint $table) {
            // Xóa khóa ngoại trước
            $table->dropForeign(['buoi_nhom_id']);

            // Sau đó xóa cột
            $table->dropColumn('buoi_nhom_id');
        });
    }
};
