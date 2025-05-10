<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDefaultUrlToNguoiDungPhanQuyenTable extends Migration
{
    public function up()
    {
        Schema::table('nguoi_dung_phan_quyen', function (Blueprint $table) {
            $table->string('default_url')->nullable()->after('quyen');
        });
    }

    public function down()
    {
        Schema::table('nguoi_dung_phan_quyen', function (Blueprint $table) {
            $table->dropColumn('default_url');
        });
    }
}