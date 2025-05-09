<?php

use Illuminate\Support\Facades\Route;

// Routes cho Thiết Bị
Route::middleware(['auth'])->group(function () {
    // Routes cho Thiết Bị
    Route::get('/thiet-bi', [App\Http\Controllers\ThietBiController::class, 'index'])
        ->middleware('checkPermission:view-thiet-bi')
        ->name('thiet-bi.index');
    Route::get('/thiet-bi/get-thiet-bis', [App\Http\Controllers\ThietBiController::class, 'getThietBis'])
        ->middleware('checkPermission:view-thiet-bi')
        ->name('thiet-bi.get-thiet-bis');
    Route::post('/thiet-bi', [App\Http\Controllers\ThietBiController::class, 'store'])
        ->middleware('checkPermission:manage-thiet-bi')
        ->name('thiet-bi.store');
    Route::get('/thiet-bi/{thietBi}', [App\Http\Controllers\ThietBiController::class, 'show'])
        ->middleware('checkPermission:view-thiet-bi')
        ->name('thiet-bi.show');
    Route::get('/thiet-bi/{thietBi}/edit', [App\Http\Controllers\ThietBiController::class, 'edit'])
        ->middleware('checkPermission:manage-thiet-bi')
        ->name('thiet-bi.edit');
    Route::post('/thiet-bi/{thietBi}', [App\Http\Controllers\ThietBiController::class, 'update'])
        ->middleware('checkPermission:manage-thiet-bi')
        ->name('thiet-bi.update');
    Route::delete('/thiet-bi/{thietBi}', [App\Http\Controllers\ThietBiController::class, 'destroy'])
        ->middleware('checkPermission:manage-thiet-bi')
        ->name('thiet-bi.destroy');

    Route::get('/thiet-bi-canh-bao', [App\Http\Controllers\ThietBiController::class, 'danhSachCanhBao'])
        ->middleware('checkPermission:view-thiet-bi-canh-bao')
        ->name('thiet-bi.canh-bao');
    Route::get('/thiet-bi-bao-cao', [App\Http\Controllers\ThietBiController::class, 'baoCao'])
        ->middleware('checkPermission:view-thiet-bi-bao-cao')
        ->name('thiet-bi.bao-cao');
    Route::get('/thiet-bi-export-excel', [App\Http\Controllers\ThietBiController::class, 'exportExcel'])
        ->middleware('checkPermission:export-thiet-bi')
        ->name('thiet-bi.export-excel');
    Route::get('/thiet-bi-export-pdf', [App\Http\Controllers\ThietBiController::class, 'exportPDF'])
        ->middleware('checkPermission:export-thiet-bi')
        ->name('thiet-bi.export-pdf');

    // Routes cho Nhà Cung Cấp
    Route::get('/nha-cung-cap', [App\Http\Controllers\NhaCungCapController::class, 'index'])
        ->middleware('checkPermission:view-nha-cung-cap')
        ->name('nha-cung-cap.index');
    Route::get('/nha-cung-cap/get-nha-cung-caps', [App\Http\Controllers\NhaCungCapController::class, 'getNhaCungCaps'])
        ->middleware('checkPermission:view-nha-cung-cap')
        ->name('nha-cung-cap.get-nha-cung-caps');
    Route::post('/nha-cung-cap', [App\Http\Controllers\NhaCungCapController::class, 'store'])
        ->middleware('checkPermission:manage-nha-cung-cap')
        ->name('nha-cung-cap.store');
    Route::get('/nha-cung-cap/{nhaCungCap}', [App\Http\Controllers\NhaCungCapController::class, 'show'])
        ->middleware('checkPermission:view-nha-cung-cap')
        ->name('nha-cung-cap.show');
    Route::get('/nha-cung-cap/{nhaCungCap}/edit', [App\Http\Controllers\NhaCungCapController::class, 'edit'])
        ->middleware('checkPermission:manage-nha-cung-cap')
        ->name('nha-cung-cap.edit');
    Route::put('/nha-cung-cap/{nhaCungCap}', [App\Http\Controllers\NhaCungCapController::class, 'update'])
        ->middleware('checkPermission:manage-nha-cung-cap')
        ->name('nha-cung-cap.update');
    Route::delete('/nha-cung-cap/{nhaCungCap}', [App\Http\Controllers\NhaCungCapController::class, 'destroy'])
        ->middleware('checkPermission:manage-nha-cung-cap')
        ->name('nha-cung-cap.destroy');

    // Routes cho Lịch Sử Bảo Trì
    Route::get('/lich-su-bao-tri/thiet-bi/{thietBiId}', [App\Http\Controllers\LichSuBaoTriController::class, 'getByThietBi'])
        ->middleware('checkPermission:view-lich-su-bao-tri')
        ->name('lich-su-bao-tri.get-by-thiet-bi');
    Route::post('/lich-su-bao-tri', [App\Http\Controllers\LichSuBaoTriController::class, 'store'])
        ->middleware('checkPermission:manage-lich-su-bao-tri')
        ->name('lich-su-bao-tri.store');
    Route::get('/lich-su-bao-tri/{lichSuBaoTri}/edit', [App\Http\Controllers\LichSuBaoTriController::class, 'edit'])
        ->middleware('checkPermission:manage-lich-su-bao-tri')
        ->name('lich-su-bao-tri.edit');
    Route::put('/lich-su-bao-tri/{lichSuBaoTri}', [App\Http\Controllers\LichSuBaoTriController::class, 'update'])
        ->middleware('checkPermission:manage-lich-su-bao-tri')
        ->name('lich-su-bao-tri.update');
    Route::delete('/lich-su-bao-tri/{lichSuBaoTri}', [App\Http\Controllers\LichSuBaoTriController::class, 'destroy'])
        ->middleware('checkPermission:manage-lich-su-bao-tri')
        ->name('lich-su-bao-tri.destroy');

    // Routes cho Tín Hữu (Người Quản Lý)
    Route::get('/tin-huu/get-tin-huus', [App\Http\Controllers\TinHuuController::class, 'getTinHuus'])
        ->middleware('checkPermission:view-tin-huu')
        ->name('tin-huu.get-tin-huus');
});
