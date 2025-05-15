<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('tham_vieng', function (Blueprint $table) {
            $table->string('loai_tham')->nullable()->after('noi_dung'); // Thêm cột loai_tham, có thể null
        });
    }

    public function down()
    {
        Schema::table('tham_vieng', function (Blueprint $table) {
            $table->dropColumn('loai_tham');
        });
    }
};
