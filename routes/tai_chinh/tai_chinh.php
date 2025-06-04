<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ThuQuy\DashboardController;
use App\Http\Controllers\ThuQuy\QuyTaiChinhController;
use App\Http\Controllers\ThuQuy\GiaoDichTaiChinhController;
use App\Http\Controllers\ThuQuy\GiaoDichTaoController;
use App\Http\Controllers\ThuQuy\GiaoDichDuyetController;
use App\Http\Controllers\ThuQuy\GiaoDichSearchController;
use App\Http\Controllers\ThuQuy\ChiDinhKyController;
use App\Http\Controllers\ThuQuy\BaoCaoTaiChinhController;
use App\Http\Controllers\ThuQuy\LichSuThaoTacController;

Route::prefix('thu-quy')->name('_thu_quy.')->middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])
        ->middleware('permission:view-thu-quy-dashboard')
        ->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware('permission:view-thu-quy-dashboard')
        ->name('dashboard');

    // Thông báo
    Route::put('/thong-bao/{id}/danh-dau-da-doc', [DashboardController::class, 'danhDauThongBaoDaDoc'])
        ->middleware('permission:view-thu-quy-thong-bao')
        ->name('thong_bao.danh_dau_da_doc');
    Route::put('/thong-bao/danh-dau-tat-ca', [DashboardController::class, 'danhDauTatCaDaDoc'])
        ->middleware('permission:view-thu-quy-thong-bao')
        ->name('thong_bao.danh_dau_tat_ca');
    Route::get('/thong-bao', [DashboardController::class, 'tatCaThongBao'])
        ->middleware('permission:view-thu-quy-thong-bao')
        ->name('thong_bao.index');
    Route::get('/thong-bao/so-luong', [DashboardController::class, 'soLuongThongBaoChuaDoc'])
        ->middleware('permission:view-thu-quy-thong-bao')
        ->name('thong_bao.so_luong');

    // Quản lý Quỹ tài chính
    Route::get('/quy/data', [QuyTaiChinhController::class, 'getDanhSachQuy'])
        ->middleware('permission:view-thu-quy-quy')
        ->name('quy.data');
    Route::get('/quy/{id}/giao-dich', [QuyTaiChinhController::class, 'giaoDichQuy'])
        ->middleware('permission:view-thu-quy-quy')
        ->name('quy.giao_dich');
    Route::get('/quy/{id}/giao-dich/data', [QuyTaiChinhController::class, 'getGiaoDichQuy'])
        ->middleware('permission:view-thu-quy-quy')
        ->name('quy.giao_dich.data');
    Route::resource('quy', QuyTaiChinhController::class)->parameters(['quy' => 'id'])
        ->middleware('permission:manage-thu-quy-quy');

    // Quản lý Giao dịch tài chính
    Route::get('/giao-dich/data', [GiaoDichTaiChinhController::class, 'getDanhSachGiaoDich'])
        ->middleware('permission:view-thu-quy-giao-dich')
        ->name('giao_dich.data');
    Route::resource('giao-dich', GiaoDichTaiChinhController::class)
        ->only(['index', 'show'])
        ->parameters(['giao-dich' => 'id'])
        ->middleware('permission:view-thu-quy-giao-dich')
        ->names([
            'index' => 'giao_dich.index',
            'show' => 'giao_dich.show',
        ]);

    // Tạo và cập nhật giao dịch
    Route::get('/giao-dich/create', [GiaoDichTaoController::class, 'create'])
        ->middleware('permission:manage-thu-quy-giao-dich')
        ->name('giao_dich.create');
    Route::post('/giao-dich', [GiaoDichTaoController::class, 'store'])
        ->middleware('permission:manage-thu-quy-giao-dich')
        ->name('giao_dich.store');
    Route::get('/giao-dich/{id}/edit', [GiaoDichTaoController::class, 'edit'])
        ->middleware('permission:manage-thu-quy-giao-dich')
        ->name('giao_dich.edit');
    Route::put('/giao-dich/{id}', [GiaoDichTaoController::class, 'update'])
        ->middleware('permission:manage-thu-quy-giao-dich')
        ->name('giao_dich.update');
    Route::delete('/giao-dich/{id}', [GiaoDichTaoController::class, 'destroy'])
        ->middleware('permission:manage-thu-quy-giao-dich')
        ->name('giao_dich.destroy');

    // Duyệt giao dịch
    Route::get('/giao-dich/{id}/duyet', [GiaoDichDuyetController::class, 'show'])
        ->middleware('permission:duyet-thu-quy-giao-dich')
        ->name('giao_dich.duyet.show');
    Route::put('/giao-dich/{id}/duyet', [GiaoDichDuyetController::class, 'update'])
        ->middleware('permission:duyet-thu-quy-giao-dich')
        ->name('giao_dich.duyet.update');
    Route::get('/giao-dich/duyet/danh-sach', [GiaoDichDuyetController::class, 'danhSachChoDuyet'])
        ->middleware('permission:duyet-thu-quy-giao-dich')
        ->name('giao_dich.duyet.danh_sach');
    Route::get('/giao-dich/duyet/data', [GiaoDichDuyetController::class, 'getDanhSachChoDuyet'])
        ->middleware('permission:duyet-thu-quy-giao-dich')
        ->name('giao_dich.duyet.data');

    // Tìm kiếm và xuất giao dịch
    Route::get('/giao-dich/tim-kiem', [GiaoDichSearchController::class, 'index'])
        ->middleware('permission:search-thu-quy-giao-dich')
        ->name('giao_dich.search');
    Route::post('/giao-dich/tim-kiem', [GiaoDichSearchController::class, 'search'])
        ->middleware('permission:search-thu-quy-giao-dich')
        ->name('giao_dich.search.results');
    Route::get('/giao-dich/xuat-pdf', [GiaoDichSearchController::class, 'xuatPDF'])
        ->middleware('permission:export-thu-quy-giao-dich')
        ->name('giao_dich.xuat_pdf');
    Route::get('/giao-dich/xuat-excel', [GiaoDichSearchController::class, 'xuatExcel'])
        ->middleware('permission:export-thu-quy-giao-dich')
        ->name('giao_dich.xuat_excel');

    // Quản lý Chi định kỳ
    Route::get('/chi-dinh-ky/data', [ChiDinhKyController::class, 'getDanhSachChiDinhKy'])
        ->middleware('permission:view-thu-quy-chi-dinh-ky')
        ->name('chi_dinh_ky.data');
    Route::get('/chi-dinh-ky/{id}/tao-giao-dich', [ChiDinhKyController::class, 'taoGiaoDich'])
        ->middleware('permission:manage-thu-quy-chi-dinh-ky')
        ->name('chi_dinh_ky.tao_giao_dich');
    Route::get('/chi-dinh-ky/kiem-tra-tu-dong', [ChiDinhKyController::class, 'kiemTraVaTaoGiaoDichTuDong'])
        ->middleware('permission:manage-thu-quy-chi-dinh-ky')
        ->name('chi_dinh_ky.kiem_tra_tu_dong');
    Route::resource('chi-dinh-ky', ChiDinhKyController::class)
        ->parameters(['chi-dinh-ky' => 'id'])
        ->middleware('permission:manage-thu-quy-chi-dinh-ky')
        ->names([
            'index' => 'chi_dinh_ky.index',
            'create' => 'chi_dinh_ky.create',
            'store' => 'chi_dinh_ky.store',
            'show' => 'chi_dinh_ky.show',
            'edit' => 'chi_dinh_ky.edit',
            'update' => 'chi_dinh_ky.update',
            'destroy' => 'chi_dinh_ky.destroy',
        ]);

    // Quản lý Báo cáo tài chính
    Route::get('/bao-cao/data', [BaoCaoTaiChinhController::class, 'getDanhSachBaoCao'])
        ->middleware('permission:view-thu-quy-bao-cao')
        ->name('bao_cao.data');
    Route::get('/bao-cao/{id}/download', [BaoCaoTaiChinhController::class, 'download'])
        ->middleware('permission:view-thu-quy-bao-cao')
        ->name('bao_cao.download');
    Route::resource('bao-cao', BaoCaoTaiChinhController::class)
        ->parameters(['bao-cao' => 'id'])
        ->middleware('permission:manage-thu-quy-bao-cao')
        ->names([
            'index' => 'bao_cao.index',
            'create' => 'bao_cao.create',
            'store' => 'bao_cao.store',
            'show' => 'bao_cao.show',
            'edit' => 'bao_cao.edit',
            'update' => 'bao_cao.update',
            'destroy' => 'bao_cao.destroy',
        ]);

    // Lịch sử thao tác
    Route::get('/lich-su', [LichSuThaoTacController::class, 'index'])
        ->middleware('permission:view-thu-quy-lich-su')
        ->name('lich_su.index');
    Route::get('/lich-su/data', [LichSuThaoTacController::class, 'getData'])
        ->middleware('permission:view-thu-quy-lich-su')
        ->name('lich_su.data');
});
