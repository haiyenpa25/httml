<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dien_gia', function (Blueprint $table) {
            $table->id();
            $table->string('ho_ten');
            $table->enum('chuc_danh', ['Thầy', 'Cô', 'Mục sư', 'Mục sư nhiệm chức', 'Truyền Đạo', 'Chấp Sự']);
            $table->string('hoi_thanh')->nullable();
            $table->string('dia_chi')->nullable();
            $table->string('so_dien_thoai')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dien_gia');
    }
};
