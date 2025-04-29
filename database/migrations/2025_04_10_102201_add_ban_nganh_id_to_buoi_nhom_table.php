<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('buoi_nhom', function (Blueprint $table) {
            // Thêm cột ban_nganh_id sau cột lich_buoi_nhom_id (hoặc vị trí khác tùy ý)
            $table->foreignId('ban_nganh_id') // Tạo cột kiểu BIGINT UNSIGNED
                ->nullable() // Cho phép NULL nếu buổi nhóm có thể không thuộc ban ngành nào
                ->after('lich_buoi_nhom_id') // Vị trí cột
                ->constrained('ban_nganh') // Thêm khóa ngoại đến bảng 'ban_nganh'
                ->onDelete('set null'); // Hoặc 'cascade', 'restrict' tùy logic của bạn
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('buoi_nhom', function (Blueprint $table) {
            // Xóa khóa ngoại trước khi xóa cột
            $table->dropForeign(['ban_nganh_id']);
            $table->dropColumn('ban_nganh_id');
        });
    }
};