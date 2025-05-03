<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('lich_su_thao_tac', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('nguoi_dung_id')->unsigned();
            $table->foreign('nguoi_dung_id')->references('id')->on('nguoi_dung')->onDelete('cascade');

            $table->string('hanh_dong');
            $table->string('bang_tac_dong')->nullable();
            $table->bigInteger('id_tac_dong')->nullable();
            $table->text('du_lieu_cu')->nullable(); // JSON
            $table->text('du_lieu_moi')->nullable(); // JSON
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('lich_su_thao_tac');
    }
};