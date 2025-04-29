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
        Schema::create('lich_su_bao_tri', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('thiet_bi_id');
            $table->date('ngay_bao_tri');
            $table->decimal('chi_phi', 15, 2)->nullable();
            $table->string('nguoi_thuc_hien');
            $table->text('mo_ta')->nullable();
            $table->timestamps();

            $table->foreign('thiet_bi_id')->references('id')->on('thiet_bi')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lich_su_bao_tri');
    }
};