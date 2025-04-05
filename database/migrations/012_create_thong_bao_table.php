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
        Schema::create('thong_bao', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tieu_de');
            $table->text('noi_dung');
            $table->enum('loai', ['email', 'sms', 'trong_ung_dung']);
            $table->unsignedBigInteger('nguoi_nhan_id');
            $table->enum('trang_thai', ['da_gui', 'cho_gui', 'that_bai'])->default('cho_gui');
            $table->timestamp('ngay_gui')->nullable();
            $table->timestamps();

            $table->foreign('nguoi_nhan_id')->references('id')->on('tin_huu')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('thong_bao');
    }
};