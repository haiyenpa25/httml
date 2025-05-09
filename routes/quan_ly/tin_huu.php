<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TinHuu\TinHuuController;
use App\Http\Controllers\TinHuuBanNganhController;

Route::prefix('quan-ly-tin-huu')->middleware(['auth', 'checkRole:quan_tri,truong_ban'])->group(function () {
    // Route resource cho Tín Hữu
    Route::resource('tin-huu', TinHuuController::class)->names('_tin_huu');

    // Route API cho danh sách Tín Hữu
    Route::get('/api/tin-huu', [TinHuuController::class, 'list'])->name('api.tin_huu.list');

    // Route cho danh sách nhân sự
    Route::get('danh-sach-nhan-su', [TinHuuController::class, 'danhSachNhanSu'])->name('_tin_huu.nhan_su');

    // Routes cho Tín Hữu Ban Ngành
    Route::get('/tin-huu-ban-nganh', [TinHuuBanNganhController::class, 'index'])->name('_tin_huu_ban_nganh.index');
    Route::post('/tin-huu-ban-nganh', [TinHuuBanNganhController::class, 'store'])->name('_tin_huu_ban_nganh.store');
    Route::get('/tin-huu-ban-nganh/members', [TinHuuBanNganhController::class, 'getMembers'])->name('_tin_huu_ban_nganh.members');
    Route::delete('/tin-huu-ban-nganh', [TinHuuBanNganhController::class, 'destroy'])->name('_tin_huu_ban_nganh.destroy');
    Route::get('/tin-huu-ban-nganh/edit', [TinHuuBanNganhController::class, 'edit'])->name('_tin_huu_ban_nganh.edit');
    Route::put('/tin-huu-ban-nganh/update', [TinHuuBanNganhController::class, 'update'])->name('_tin_huu_ban_nganh.update');
});
