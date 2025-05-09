<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nguoi_dung_phan_quyen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nguoi_dung_id')->constrained('nguoi_dung')->onDelete('cascade');
            $table->string('quyen');
            $table->foreignId('id_ban_nganh')->nullable()->constrained('ban_nganh')->onDelete('set null');
            $table->timestamps();
            $table->unique(['nguoi_dung_id', 'quyen', 'id_ban_nganh']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nguoi_dung_phan_quyen');
    }
};
