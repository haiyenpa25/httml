<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BanChapSuController;
use App\Http\Controllers\BanAmThucController;
use App\Http\Controllers\BanCauNguyenController;
use App\Http\Controllers\BanChungDaoController;
use App\Http\Controllers\BanCoDocGiaoDucController;
use App\Http\Controllers\BanDanController;
use App\Http\Controllers\BanHauCanController;
use App\Http\Controllers\BanHatThoPhuongController;
use App\Http\Controllers\BanKhanhTietController;
use App\Http\Controllers\BanKyThuatAmThanhController;
use App\Http\Controllers\BanLeTanController;
use App\Http\Controllers\BanMayChieuController;
use App\Http\Controllers\BanThamViengController;
use App\Http\Controllers\BanTratTuController;
use App\Http\Controllers\BanTruyenGiangController;
use App\Http\Controllers\BanTruyenThongMayChieuController;
use App\Http\Controllers\BanThanhNienController;
use App\Http\Controllers\BanThanhTrangController;
use App\Http\Controllers\BanThieuNhiAuController;
use App\Http\Controllers\BanTrungLaoController;
use App\Http\Controllers\TinHuuController;
use App\Http\Controllers\DienGiaController;
use App\Http\Controllers\ThanHuuController;
use App\Http\Controllers\ThietBiController;
use App\Http\Controllers\TaiChinhController;
use App\Http\Controllers\ThoPhuongController;
use App\Http\Controllers\TaiLieuController;
use App\Http\Controllers\ThongBaoController;
use App\Http\Controllers\BaoCaoController; // Controller chung cho báo cáo
use App\Http\Controllers\CaiDatController; // Controller cho cài đặt hệ thống
use App\Http\Controllers\UserController;
use App\Http\Controllers\NguoiDungController;


Route::get('/', function () {
    return view('dashboard');
});

Route::resource('nguoi-dung', NguoiDungController::class)->names([
    'index' => '_nguoi_dung.index',
    'create' => '_nguoi_dung.create',
    'store' => '_nguoi_dung.store',
    'show' => '_nguoi_dung.show',
    'edit' => '_nguoi_dung.edit',
    'update' => '_nguoi_dung.update',
    'destroy' => '_nguoi_dung.destroy',
]);





// Quản lý Tín Hữu (Chỉ cho quản trị viên và trưởng ban)
Route::prefix('quan-ly-tin-huu')->middleware('checkRole:quan_tri,truong_ban')->group(function () {
    Route::resource('tin-huu', TinHuuController::class)->names([
        'index' => 'tin-huu.index',
        'create' => 'tin-huu.create',
        'store' => 'tin-huu.store',
        'show' => 'tin-huu.show',
        'edit' => 'tin-huu.edit',
        'update' => 'tin-huu.update',
        'destroy' => 'tin-huu.destroy',
    ]);
    Route::get('danh-sach-nhan-su', [TinHuuController::class, 'danhSachNhanSu'])->name('tin-huu.nhan_su');
});

// Quản lý Diễn Giả (Chỉ cho quản trị viên)
Route::prefix('quan-ly-dien-gia')->middleware('checkRole:quan_tri')->group(function () {
    Route::resource('dien-gia', DienGiaController::class)->names([
        'index' => 'dien-gia.index',
        'create' => 'dien-gia.create',
        'store' => 'dien-gia.store',
        'show' => 'dien-gia.show',
        'edit' => 'dien-gia.edit',
        'update' => 'dien-gia.update',
        'destroy' => 'dien-gia.destroy',
    ]);
});

// Quản lý Thân Hữu (Quản trị viên và trưởng ban)
Route::prefix('quan-ly-than-huu')->middleware('checkRole:quan_tri,truong_ban')->group(function () {
    Route::resource('than-huu', ThanHuuController::class)->names([
        'index' => 'than-huu.index',
        'create' => 'than-huu.create',
        'store' => 'than-huu.store',
        'show' => 'than-huu.show',
        'edit' => 'than-huu.edit',
        'update' => 'than-huu.update',
        'destroy' => 'than-huu.destroy',
    ]);
});

// Quản lý Thiết bị (Quản trị viên và trưởng ban)
Route::prefix('quan-ly-thiet-bi')->middleware('checkRole:quan_tri,truong_ban')->group(function () {
    Route::resource('thiet-bi', ThietBiController::class)->names([
        'index' => 'thiet-bi.index',
        'create' => 'thiet-bi.create',
        'store' => 'thiet-bi.store',
        'show' => 'thiet-bi.show',
        'edit' => 'thiet-bi.edit',
        'update' => 'thiet-bi.update',
        'destroy' => 'thiet-bi.destroy',
    ]);
    Route::get('bao-cao-thiet-bi', [ThietBiController::class, 'baoCao'])->name('thiet-bi.bao_cao');
    Route::get('thanh-ly-thiet-bi', [ThietBiController::class, 'thanhLy'])->name('thiet-bi.thanh_ly');
});

// Quản lý Tài Chính (Chỉ quản trị viên)
Route::prefix('quan-ly-tai-chinh')->middleware('checkRole:quan_tri')->group(function () {
    Route::get('bao-cao-tai-chinh', [TaiChinhController::class, 'baoCao'])->name('tai-chinh.bao_cao');
    Route::resource('thu-chi', TaiChinhController::class)->names([
        'index' => 'thu-chi.index',
        'create' => 'thu-chi.create',
        'store' => 'thu-chi.store',
        'show' => 'thu-chi.show',
        'edit' => 'thu-chi.edit',
        'update' => 'thu-chi.update',
        'destroy' => 'thu-chi.destroy',
    ]);
});

// Quản lý Thờ Phượng (Quản trị viên, trưởng ban, thành viên)
Route::prefix('quan-ly-tho-phuong')->middleware('checkRole:quan_tri,truong_ban,thanh_vien')->group(function () {
   Route::resource('tho-phuong', ThoPhuongController::class)->names([
        'index' => 'tho-phuong.index',
        'create' => 'tho-phuong.create',
        'store' => 'tho-phuong.store',
        'show' => 'tho-phuong.show',
        'edit' => 'tho-phuong.edit',
        'update' => 'tho-phuong.update',
        'destroy' => 'tho-phuong.destroy',
    ]);
});

// Quản lý Tài liệu (Quản trị viên và trưởng ban)
Route::prefix('quan-ly-tai-lieu')->middleware('checkRole:quan_tri,truong_ban')->group(function () {
    Route::resource('tai-lieu', TaiLieuController::class)->names([
        'index' => 'tai-lieu.index',
        'create' => 'tai-lieu.create',
        'store' => 'tai-lieu.store',
        'show' => 'tai-lieu.show',
        'edit' => 'tai-lieu.edit',
        'update' => 'tai-lieu.update',
        'destroy' => 'tai-lieu.destroy',
    ]);
});

// Quản lý Thông báo (Quản trị viên và trưởng ban)
Route::get('quan-ly-thong-bao/thong-bao', [ThongBaoController::class, 'index'])->middleware('checkRole:quan_tri,truong_ban')->name('thong-bao.index');

// Báo cáo (Chỉ quản trị viên)
Route::prefix('bao-cao')->middleware('checkRole:quan_tri')->group(function () {
    Route::get('bao-cao-tho-phuong', [BaoCaoController::class, 'baoCaoThoPhuong'])->name('bao-cao.tho_phuong');
    Route::get('bao-cao-thiet-bi', [BaoCaoController::class, 'baoCaoThietBi'])->name('bao-cao.thiet_bi');
    Route::get('bao-cao-tai-chinh', [BaoCaoController::class, 'baoCaoTaiChinh'])->name('bao-cao.tai_chinh');
    Route::get('bao-cao-ban-nganh', [BaoCaoController::class, 'baoCaoBanNganh'])->name('bao-cao.ban_nganh');
});

// Cài đặt (Chỉ quản trị viên)
Route::get('cai-dat/cai-dat-he-thong', [CaiDatController::class, 'index'])->middleware('checkRole:quan_tri')->name('cai-dat.he_thong');

// Quản lý Người Dùng (Chỉ quản trị viên)
Route::prefix('quan-ly-nguoi-dung')->middleware('checkRole:quan_tri')->group(function () {
    
});