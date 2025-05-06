<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tin_huu_trinh_do', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tin_huu_id');
            $table->string('ten_khoa_hoc')->nullable();
            $table->date('ngay_tot_nghiep')->nullable();
            $table->string('chung_chi')->nullable();
            $table->text('ghi_chu')->nullable();
            $table->timestamps();

            $table->foreign('tin_huu_id')->references('id')->on('tin_huu')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tin_huu_trinh_do');
    }
};
