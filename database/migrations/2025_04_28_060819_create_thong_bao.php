<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('thong_bao', function (Blueprint $table) {
            // Thêm trường người gửi
            $table->unsignedBigInteger('nguoi_gui_id')->after('nguoi_nhan_id');
            $table->foreign('nguoi_gui_id')->references('id')->on('nguoi_dung')->onDelete('cascade');

            // Thêm trường đánh dấu đã đọc
            $table->boolean('da_doc')->default(false)->after('ngay_gui');

            // Thêm trường lưu trữ
            $table->boolean('luu_tru')->default(false)->after('da_doc');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('thong_bao', function (Blueprint $table) {
            $table->dropForeign(['nguoi_gui_id']);
            $table->dropColumn(['nguoi_gui_id', 'da_doc', 'luu_tru']);
        });
    }
};
