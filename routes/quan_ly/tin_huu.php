<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TinHuu\TinHuuController;
use App\Http\Controllers\TinHuuBanNganhController;

Route::prefix('quan-ly-tin-huu')->middleware(['auth'])->group(function () {
    Route::get('tin-huu', [TinHuuController::class, 'index'])
        ->middleware('checkPermission:view-tin-huu')
        ->name('_tin_huu.index');

    Route::get('tin-huu/create', [TinHuuController::class, 'create'])
        ->middleware('checkPermission:create-tin-huu')
        ->name('_tin_huu.create');

    Route::post('tin-huu', [TinHuuController::class, 'store'])
        ->middleware('checkPermission:create-tin-huu')
        ->name('_tin_huu.store');

    Route::get('tin-huu/{id}', [TinHuuController::class, 'show'])
        ->middleware('checkPermission:view-tin-huu')
        ->name('_tin_huu.show');

    Route::get('tin-huu/{id}/edit', [TinHuuController::class, 'edit'])
        ->middleware('checkPermission:update-tin-huu')
        ->name('_tin_huu.edit');

    Route::put('tin-huu/{id}', [TinHuuController::class, 'update'])
        ->middleware('checkPermission:update-tin-huu')
        ->name('_tin_huu.update');

    Route::delete('tin-huu/{id}', [TinHuuController::class, 'destroy'])
        ->middleware('checkPermission:delete-tin-huu')
        ->name('_tin_huu.destroy');

    Route::get('/api/tin-huu', [TinHuuController::class, 'list'])
        ->middleware('checkPermission:view-tin-huu')
        ->name('api.tin_huu.list');

    Route::get('danh-sach-nhan-su', [TinHuuController::class, 'danhSachNhanSu'])
        ->middleware('checkPermission:view-nhan-su')
        ->name('_tin_huu.nhan_su');

    Route::get('/tin-huu-ban-nganh', [TinHuuBanNganhController::class, 'index'])
        ->middleware('checkPermission:view-tin-huu')
        ->name('_tin_huu_ban_nganh.index');

    Route::post('/tin-huu-ban-nganh', [TinHuuBanNganhController::class, 'store'])
        ->middleware('checkPermission:update-tin-huu')
        ->name('_tin_huu_ban_nganh.store');

    Route::get('/tin-huu-ban-nganh/members', [TinHuuBanNganhController::class, 'getMembers'])
        ->middleware('checkPermission:view-tin-huu')
        ->name('_tin_huu_ban_nganh.members');

    Route::delete('/tin-huu-ban-nganh', [TinHuuBanNganhController::class, 'destroy'])
        ->middleware('checkPermission:delete-tin-huu')
        ->name('_tin_huu_ban_nganh.destroy');

    Route::get('/tin-huu-ban-nganh/edit', [TinHuuBanNganhController::class, 'edit'])
        ->middleware('checkPermission:update-tin-huu')
        ->name('_tin_huu_ban_nganh.edit');

    Route::put('/tin-huu-ban-nganh/update', [TinHuuBanNganhController::class, 'update'])
        ->middleware('checkPermission:update-tin-huu')
        ->name('_tin_huu_ban_nganh.update');
});
