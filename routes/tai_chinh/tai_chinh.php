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
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Thông báo
    Route::put('/thong-bao/{id}/danh-dau-da-doc', [DashboardController::class, 'danhDauThongBaoDaDoc'])->name('thong_bao.danh_dau_da_doc');
    Route::put('/thong-bao/danh-dau-tat-ca', [DashboardController::class, 'danhDauTatCaDaDoc'])->name('thong_bao.danh_dau_tat_ca');
    Route::get('/thong-bao', [DashboardController::class, 'tatCaThongBao'])->name('thong_bao.index');
    Route::get('/thong-bao/so-luong', [DashboardController::class, 'soLuongThongBaoChuaDoc'])->name('thong_bao.so_luong');

    // Quản lý Quỹ tài chính
    Route::get('/quy/data', [QuyTaiChinhController::class, 'getDanhSachQuy'])->name('quy.data');
    Route::get('/quy/{id}/giao-dich', [QuyTaiChinhController::class, 'giaoDichQuy'])->name('quy.giao_dich');
    Route::get('/quy/{id}/giao-dich/data', [QuyTaiChinhController::class, 'getGiaoDichQuy'])->name('quy.giao_dich.data');
    Route::resource('quy', QuyTaiChinhController::class)->parameters(['quy' => 'id']);

    // Quản lý Giao dịch tài chính
    Route::get('/giao-dich/data', [GiaoDichTaiChinhController::class, 'getDanhSachGiaoDich'])->name('giao_dich.data');
    Route::resource('giao-dich', GiaoDichTaiChinhController::class)->only(['index', 'show'])->parameters(['giao-dich' => 'id']);

    // Tạo và cập nhật giao dịch
    Route::get('/giao-dich/create', [GiaoDichTaoController::class, 'create'])->name('giao_dich.create');
    Route::post('/giao-dich', [GiaoDichTaoController::class, 'store'])->name('giao_dich.store');
    Route::get('/giao-dich/{id}/edit', [GiaoDichTaoController::class, 'edit'])->name('giao_dich.edit');
    Route::put('/giao-dich/{id}', [GiaoDichTaoController::class, 'update'])->name('giao_dich.update');
    Route::delete('/giao-dich/{id}', [GiaoDichTaoController::class, 'destroy'])->name('giao_dich.destroy');

    // Duyệt giao dịch
    Route::get('/giao-dich/{id}/duyet', [GiaoDichDuyetController::class, 'show'])->name('giao_dich.duyet.show');
    Route::put('/giao-dich/{id}/duyet', [GiaoDichDuyetController::class, 'update'])->name('giao_dich.duyet.update');
    Route::get('/giao-dich/duyet/danh-sach', [GiaoDichDuyetController::class, 'danhSachChoDuyet'])->name('giao_dich.duyet.danh_sach');
    Route::get('/giao-dich/duyet/data', [GiaoDichDuyetController::class, 'getDanhSachChoDuyet'])->name('giao_dich.duyet.data');

    // Tìm kiếm và xuất giao dịch
    Route::get('/giao-dich/tim-kiem', [GiaoDichSearchController::class, 'index'])->name('giao_dich.search');
    Route::post('/giao-dich/tim-kiem', [GiaoDichSearchController::class, 'search'])->name('giao_dich.search.results');
    Route::get('/giao-dich/xuat-pdf', [GiaoDichSearchController::class, 'xuatPDF'])->name('giao_dich.xuat_pdf');
    Route::get('/giao-dich/xuat-excel', [GiaoDichSearchController::class, 'xuatExcel'])->name('giao_dich.xuat_excel');

    // Quản lý Chi định kỳ
    Route::get('/chi-dinh-ky/data', [ChiDinhKyController::class, 'getDanhSachChiDinhKy'])->name('chi_dinh_ky.data');
    Route::get('/chi-dinh-ky/{id}/tao-giao-dich', [ChiDinhKyController::class, 'taoGiaoDich'])->name('chi_dinh_ky.tao_giao_dich');
    Route::get('/chi-dinh-ky/kiem-tra-tu-dong', [ChiDinhKyController::class, 'kiemTraVaTaoGiaoDichTuDong'])->name('chi_dinh_ky.kiem_tra_tu_dong');
    Route::resource('chi-dinh-ky', ChiDinhKyController::class)->parameters(['chi-dinh-ky' => 'id']);

    // Quản lý Báo cáo tài chính
    Route::get('/bao-cao/data', [BaoCaoTaiChinhController::class, 'getDanhSachBaoCao'])->name('bao_cao.data');
    Route::get('/bao-cao/{id}/download', [BaoCaoTaiChinhController::class, 'download'])->name('bao_cao.download');
    Route::resource('bao-cao', BaoCaoTaiChinhController::class)->parameters(['bao-cao' => 'id']);

    // Lịch sử thao tác
    Route::get('/lich-su', [LichSuThaoTacController::class, 'index'])->name('lich_su.index');
    Route::get('/lich-su/data', [LichSuThaoTacController::class, 'getData'])->name('lich_su.data');
});
