<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('buoi_nhom_lich', function (Blueprint $table) {
            // Xoá cột ENUM cũ
            $table->dropColumn('loai');

            // Thêm cột id_buoi_nhom_loai mới
            $table->unsignedBigInteger('id_buoi_nhom_loai')->nullable()->after('id');

            // Thêm ràng buộc khóa ngoại (nếu cần)
            $table->foreign('id_buoi_nhom_loai')
                ->references('id')->on('buoi_nhom_loai')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('buoi_nhom_lich', function (Blueprint $table) {
            // Huỷ khóa ngoại và xoá cột mới
            $table->dropForeign(['id_buoi_nhom_loai']);
            $table->dropColumn('id_buoi_nhom_loai');

            // Thêm lại ENUM cũ (nếu cần rollback)
            $table->enum('loai', ['tuan', 'thang', 'khac'])->nullable();
        });
    }
};
