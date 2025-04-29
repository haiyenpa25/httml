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
        Schema::create('tin_huu', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ho_ten');
            $table->date('ngay_sinh');
            $table->text('dia_chi');
            $table->float('vi_do')->nullable();
            $table->float('kinh_do')->nullable();
            $table->string('so_dien_thoai', 20);
            $table->enum('loai_tin_huu', ['tin_huu_chinh_thuc', 'tan_tin_huu', 'tin_huu_ht_khac']);
            $table->date('ngay_tin_chua')->nullable();
            $table->date('ngay_tham_vieng_gan_nhat')->nullable();
            $table->integer('so_lan_vang_lien_tiep')->default(0);
            $table->unsignedBigInteger('ho_gia_dinh_id')->nullable();
            $table->enum('moi_quan_he', ['cha', 'me', 'con', 'anh', 'chi', 'em', 'khac'])->nullable();
            $table->string('anh_dai_dien')->nullable();
            $table->enum('gioi_tinh', ['nam', 'nu']);
            $table->enum('tinh_trang_hon_nhan', ['doc_than', 'ket_hon']);
            $table->timestamps();

            $table->foreign('ho_gia_dinh_id')->references('id')->on('ho_gia_dinh')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tin_huu');
    }
};