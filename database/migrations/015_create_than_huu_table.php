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
        Schema::create('than_huu', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ho_ten');
            $table->year('nam_sinh');
            $table->string('so_dien_thoai', 20)->nullable();
            $table->text('dia_chi')->nullable();
            $table->unsignedBigInteger('tin_huu_gioi_thieu_id');
            $table->enum('trang_thai', ['chua_tin', 'da_tham_gia', 'da_tin_chua'])->default('chua_tin');
            $table->text('ghi_chu')->nullable();
            $table->timestamps();

            $table->foreign('tin_huu_gioi_thieu_id')->references('id')->on('tin_huu')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('than_huu');
    }
};