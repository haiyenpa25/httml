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
        Schema::table('buoi_nhom_to', function (Blueprint $table) {
            // Kiểm tra xem cột 'id_to' đã tồn tại chưa. Nếu chưa, hãy tạo nó.
            if (!Schema::hasColumn('buoi_nhom_to', 'id_to')) {
                $table->unsignedBigInteger('id_to')->nullable();
            }

            // Tạo khóa ngoại (chú ý: không kiểm tra sự tồn tại phức tạp)
            try {
                $table->foreign('id_to', 'fk_buoi_nhom_to_id_to')
                    ->references('id')
                    ->on('buoi_nhom')
                    ->onDelete('set null');
                $table->index('id_to');
            } catch (\Illuminate\Database\QueryException $e) {
                // Bắt lỗi nếu khóa ngoại đã tồn tại (có thể xảy ra trong một số trường hợp)
                if ($e->getCode() != '42S01') { // Mã lỗi cho "bảng đã tồn tại" (có thể khác nhau tùy hệ thống)
                    throw $e; // Nếu không phải lỗi "bảng đã tồn tại", ném lại lỗi
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('buoi_nhom_to', function (Blueprint $table) {
            try {
                $table->dropForeign('fk_buoi_nhom_to_id_to');
                $table->dropIndex(['id_to']);
            } catch (\Illuminate\Database\QueryException $e) {
                // Bắt lỗi nếu khóa ngoại không tồn tại (có thể xảy ra trong một số trường hợp)
                // Bạn có thể bỏ qua lỗi này hoặc log lại nếu cần
            }
        });
    }
};
