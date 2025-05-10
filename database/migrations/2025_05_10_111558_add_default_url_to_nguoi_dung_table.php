<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('nguoi_dung', function (Blueprint $table) {
            $table->string('default_url')->nullable()->after('vai_tro');
        });
    }

    public function down()
    {
        Schema::table('nguoi_dung', function (Blueprint $table) {
            $table->dropColumn('default_url');
        });
    }
};
