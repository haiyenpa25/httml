<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ThanHuuController;

// Quản lý Thân Hữu
Route::prefix('than-huu')->middleware(['auth'])->name('_than_huu.')->group(function () {
    Route::get('/', [ThanHuuController::class, 'index'])
        ->middleware('checkPermission:view-than-huu')
        ->name('index');
    Route::get('/create', [ThanHuuController::class, 'create'])
        ->middleware('checkPermission:manage-than-huu')
        ->name('create');
    Route::get('/{thanHuu}/edit', [ThanHuuController::class, 'edit'])
        ->middleware('checkPermission:manage-than-huu')
        ->name('edit');
    Route::get('/{thanHuu}', [ThanHuuController::class, 'show'])
        ->middleware('checkPermission:view-than-huu')
        ->name('show');
});

Route::prefix('api/than-huu')->middleware(['auth'])->name('api.than_huu.')->group(function () {
    Route::get('/', [ThanHuuController::class, 'getThanHuus'])
        ->middleware('checkPermission:view-than-huu')
        ->name('list');
    Route::get('/{thanHuu}', [ThanHuuController::class, 'getThanHuuJson'])
        ->middleware('checkPermission:view-than-huu')
        ->name('details');
    Route::post('/', [ThanHuuController::class, 'store'])
        ->middleware('checkPermission:manage-than-huu')
        ->name('store');
    Route::put('/{thanHuu}', [ThanHuuController::class, 'update'])
        ->middleware('checkPermission:manage-than-huu')
        ->name('update');
    Route::delete('/{thanHuu}', [ThanHuuController::class, 'destroy'])
        ->middleware('checkPermission:manage-than-huu')
        ->name('destroy');
    Route::get('/export', [ThanHuuController::class, 'exportExcel'])
        ->middleware('checkPermission:manage-than-huu')
        ->name('export');
});
