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
        Schema::create('tin_huu_ban_nganh', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('tin_huu_id');
            $table->unsignedBigInteger('ban_nganh_id');
            $table->timestamps();

            $table->foreign('tin_huu_id', 'tin_huu_ban_nganh_tin_huu_fk')->references('id')->on('tin_huu')->onDelete('cascade');
            $table->foreign('ban_nganh_id', 'tin_huu_ban_nganh_ban_nganh_fk')->references('id')->on('ban_nganh')->onDelete('cascade');

            $table->unique(['tin_huu_id', 'ban_nganh_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tin_huu_ban_nganh');
    }
};