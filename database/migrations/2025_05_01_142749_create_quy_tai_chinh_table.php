// database/migrations/2025_04_30_000001_create_quy_tai_chinh_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('quy_tai_chinh', function (Blueprint $table) {
            $table->id();
            $table->string('ten_quy');
            $table->text('mo_ta')->nullable();
            $table->decimal('so_du_hien_tai', 15, 2)->default(0);
            $table->bigInteger('nguoi_quan_ly_id')->unsigned()->nullable();
            $table->foreign('nguoi_quan_ly_id')->references('id')->on('tin_huu')->onDelete('set null');
            $table->enum('trang_thai', ['hoat_dong', 'tam_dung'])->default('hoat_dong');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('quy_tai_chinh');
    }
};