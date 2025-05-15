<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('giao_dich_tai_chinh', function (Blueprint $table) {
            $table->unsignedBigInteger('ban_nganh_id_goi')->nullable()->after('ban_nganh_id');
            $table->foreign('ban_nganh_id_goi')->references('id')->on('ban_nganh')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('giao_dich_tai_chinh', function (Blueprint $table) {
            $table->dropForeign(['ban_nganh_id_goi']);
            $table->dropColumn('ban_nganh_id_goi');
        });
    }
};
