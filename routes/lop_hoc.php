<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LopHocController;

Route::get('tin-huu/search', [App\Http\Controllers\TinHuuController::class, 'search'])
    ->middleware(['auth', 'verified'])
    ->name('tin-huu.search');

Route::prefix('lop-hoc')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [App\Http\Controllers\LopHocController::class, 'index'])
        ->middleware('checkPermission:view-lop-hoc')
        ->name('lop-hoc.index');

    Route::get('/create', [App\Http\Controllers\LopHocController::class, 'create'])
        ->middleware('checkPermission:create-lop-hoc')
        ->name('lop-hoc.create');

    Route::post('/', [App\Http\Controllers\LopHocController::class, 'store'])
        ->middleware('checkPermission:create-lop-hoc')
        ->name('lop-hoc.store');

    Route::get('/{lopHoc}', [App\Http\Controllers\LopHocController::class, 'show'])
        ->middleware('checkPermission:view-lop-hoc')
        ->name('lop-hoc.show');

    Route::get('/{lopHoc}/edit', [App\Http\Controllers\LopHocController::class, 'edit'])
        ->middleware('checkPermission:edit-lop-hoc')
        ->name('lop-hoc.edit');

    Route::put('/{lopHoc}', [App\Http\Controllers\LopHocController::class, 'update'])
        ->middleware('checkPermission:edit-lop-hoc')
        ->name('lop-hoc.update');

    Route::delete('/{lopHoc}', [App\Http\Controllers\LopHocController::class, 'destroy'])
        ->middleware('checkPermission:delete-lop-hoc')
        ->name('lop-hoc.destroy');
});

Route::post('lop-hoc/{lopHoc}/hoc-vien', [App\Http\Controllers\LopHocController::class, 'themHocVien'])
    ->middleware(['auth', 'verified', 'checkPermission:manage-hoc-vien'])
    ->name('lop-hoc.them-hoc-vien');

Route::delete('lop-hoc/{lopHoc}/hoc-vien/{tinHuu}', [App\Http\Controllers\LopHocController::class, 'xoaHocVien'])
    ->middleware(['auth', 'verified', 'checkPermission:manage-hoc-vien'])
    ->name('lop-hoc.xoa-hoc-vien');
