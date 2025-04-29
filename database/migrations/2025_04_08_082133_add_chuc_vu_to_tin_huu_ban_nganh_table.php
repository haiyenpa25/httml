<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tin_huu_ban_nganh', function (Blueprint $table) {
            $table->string('chuc_vu', 50)->nullable()->after('ban_nganh_id'); // Thêm cột chuc_vu sau ban_nganh_id
        });
    }

    public function down(): void
    {
        Schema::table('tin_huu_ban_nganh', function (Blueprint $table) {
            $table->dropColumn('chuc_vu'); // Xóa cột nếu rollback
        });
    }
};
