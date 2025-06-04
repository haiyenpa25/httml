<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DienGiaController;

// Quản lý Diễn Giả
Route::prefix('dien-gia')->middleware(['auth'])->name('_dien_gia.')->group(function () {
    Route::get('/', [DienGiaController::class, 'index'])
        ->middleware('permission:view-dien-gia')
        ->name('index');
    Route::get('/create', [DienGiaController::class, 'create'])
        ->middleware('permission:manage-dien-gia')
        ->name('create');
    Route::get('/{dienGia}/edit', [DienGiaController::class, 'edit'])
        ->middleware('permission:manage-dien-gia')
        ->name('edit');
    Route::get('/{dienGia}', [DienGiaController::class, 'show'])
        ->middleware('permission:view-dien-gia')
        ->name('show');
});

Route::prefix('api/dien-gia')->middleware(['auth'])->name('api.dien_gia.')->group(function () {
    Route::get('/', [DienGiaController::class, 'getDienGias'])
        ->middleware('permission:view-dien-gia')
        ->name('list');
    Route::get('/{dienGia}', [DienGiaController::class, 'getDienGiaJson'])
        ->middleware('permission:view-dien-gia')
        ->name('details');
    Route::post('/', [DienGiaController::class, 'store'])
        ->middleware('permission:manage-dien-gia')
        ->name('store');
    Route::put('/{dienGia}', [DienGiaController::class, 'update'])
        ->middleware('permission:manage-dien-gia')
        ->name('update');
    Route::delete('/{dienGia}', [DienGiaController::class, 'destroy'])
        ->middleware('permission:manage-dien-gia')
        ->name('destroy');
    Route::get('/export', [DienGiaController::class, 'exportExcel'])
        ->middleware('permission:manage-dien-gia')
        ->name('export');
});
