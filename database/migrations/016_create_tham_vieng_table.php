<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tham_vieng', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('tin_huu_id')->nullable();
            $table->unsignedBigInteger('than_huu_id')->nullable();
            $table->unsignedBigInteger('nguoi_tham_id');
            $table->unsignedBigInteger('id_ban')->nullable();
            $table->date('ngay_tham');
            $table->text('noi_dung');
            $table->text('ket_qua')->nullable();
            $table->enum('trang_thai', ['da_tham', 'ke_hoach'])->default('ke_hoach');
            $table->timestamps();

            $table->foreign('tin_huu_id', 'tham_vieng_tin_huu_fk')->references('id')->on('tin_huu')->onDelete('set null');
            $table->foreign('than_huu_id', 'tham_vieng_than_huu_fk')->references('id')->on('than_huu')->onDelete('set null');
            $table->foreign('nguoi_tham_id', 'tham_vieng_nguoi_tham_fk')->references('id')->on('tin_huu')->onDelete('restrict');
            $table->foreign('id_ban', 'tham_vieng_ban_nganh_fk')->references('id')->on('ban_nganh')->onDelete('set null');
        });

        DB::statement('ALTER TABLE tham_vieng ADD CONSTRAINT check_tham_vieng CHECK (tin_huu_id IS NOT NULL OR than_huu_id IS NOT NULL)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tham_vieng');
        DB::statement('ALTER TABLE tham_vieng DROP CONSTRAINT IF EXISTS check_tham_vieng');
    }
};