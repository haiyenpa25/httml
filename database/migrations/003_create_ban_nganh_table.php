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
        Schema::create('ban_nganh', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ten');
            $table->enum('loai', ['sinh_hoat', 'muc_vu']);
            $table->text('mo_ta')->nullable();
            $table->unsignedBigInteger('truong_ban_id')->nullable();
            $table->timestamps();

            $table->foreign('truong_ban_id')->references('id')->on('tin_huu')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ban_nganh');
    }
};