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
        Schema::create('buoi_nhom_loai', function (Blueprint $table) {
            $table->id(); // Hoặc $table->bigIncrements('id'); tùy theo sở thích
            $table->string('ten_loai', 100)->unique(); // Tên của loại buổi nhóm (ví dụ: hội_thánh, ban_ngành, truyền_giảng)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buoi_nhom_loai');
    }
};
