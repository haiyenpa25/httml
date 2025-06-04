<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LopHocController;

Route::get('tin-huu/search', [App\Http\Controllers\TinHuuController::class, 'search'])
    ->middleware(['auth', 'verified'])
    ->name('tin-huu.search');

Route::prefix('lop-hoc')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [LopHocController::class, 'index'])
        ->middleware('permission:view-lop-hoc')
        ->name('lop-hoc.index');
    Route::get('/create', [LopHocController::class, 'create'])
        ->middleware('permission:create-lop-hoc')
        ->name('lop-hoc.create');
    Route::post('/', [LopHocController::class, 'store'])
        ->middleware('permission:create-lop-hoc')
        ->name('lop-hoc.store');
    Route::get('/{lopHoc}', [LopHocController::class, 'show'])
        ->middleware('permission:view-lop-hoc')
        ->name('lop-hoc.show');
    Route::get('/{lopHoc}/edit', [LopHocController::class, 'edit'])
        ->middleware('permission:edit-lop-hoc')
        ->name('lop-hoc.edit');
    Route::put('/{lopHoc}', [LopHocController::class, 'update'])
        ->middleware('permission:edit-lop-hoc')
        ->name('lop-hoc.update');
    Route::delete('/{lopHoc}', [LopHocController::class, 'destroy'])
        ->middleware('permission:delete-lop-hoc')
        ->name('lop-hoc.destroy');
});

Route::post('lop-hoc/{lopHoc}/hoc-vien', [LopHocController::class, 'themHocVien'])
    ->middleware(['auth', 'verified', 'permission:manage-hoc-vien'])
    ->name('lop-hoc.them-hoc-vien');

Route::delete('lop-hoc/{lopHoc}/hoc-vien/{tinHuu}', [LopHocController::class, 'xoaHocVien'])
    ->middleware(['auth', 'verified', 'permission:manage-hoc-vien'])
    ->name('lop-hoc.xoa-hoc-vien');
