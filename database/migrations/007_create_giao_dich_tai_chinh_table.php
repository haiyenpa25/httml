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
        Schema::create('giao_dich_tai_chinh', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('loai', ['thu', 'chi']);
            $table->decimal('so_tien', 15, 2);
            $table->text('mo_ta');
            $table->date('ngay_giao_dich');
            $table->unsignedBigInteger('ban_nganh_id')->nullable();
            $table->timestamps();

            $table->foreign('ban_nganh_id')->references('id')->on('ban_nganh')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('giao_dich_tai_chinh');
    }
};