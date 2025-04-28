<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('thiet_bi', function (Blueprint $table) {
            $table->decimal('gia_tri', 15, 2)->nullable()->after('ngay_mua');
        });
    }

    public function down()
    {
        Schema::table('thiet_bi', function (Blueprint $table) {
            $table->dropColumn('gia_tri');
        });
    }
};
