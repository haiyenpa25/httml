<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('nhiem_vu', function (Blueprint $table) {
            $table->unsignedBigInteger('id_ban_nganh')->nullable()->after('ten_nhiem_vu');

            // Nếu bạn đã có bảng `ban_nganh`, thêm ràng buộc khóa ngoại:
            $table->foreign('id_ban_nganh')->references('id')->on('ban_nganh')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('nhiem_vu', function (Blueprint $table) {
            $table->dropForeign(['id_ban_nganh']);
            $table->dropColumn('id_ban_nganh');
        });
    }
};
