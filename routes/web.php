<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController,
    HoGiaDinhController,
    NguoiDungController,
    BanChapSuController,
    BanAmThucController,
    BanCauNguyenController,
    BanChungDaoController,
    BanCoDocGiaoDucController,
    BanDanController,
    BanHauCanController,
    BanHatThoPhuongController,
    BanKhanhTietController,
    BanKyThuatAmThanhController,
    BanLeTanController,
    BanMayChieuController,
    BanThamViengController,
    BanTratTuController,
    BanTruyenGiangController,
    BanTruyenThongMayChieuController,
    BanThanhNienController,
    BanThanhTrangController,
    BanThieuNhiAuController,
    BanTrungLaoController,
    DienGiaController,
    ThanHuuController,
    ThietBiController,
    TaiChinhController,
    ThoPhuongController,
    TaiLieuController,
    ThongBaoController,
    BaoCaoController,
    CaiDatController,
    BuoiNhomController,
    ChiTietThamGiaController,
    ThongBao\GuiThongBaoController,
    ThongBao\NhanThongBaoController,
    ThongBao\QuanLyThongBaoController,
    BanMucVuController,
    BanMucVu\BanMucVuThanhVienController
};

// ==== Middleware groups ====
$quanTri = ['auth', 'checkRole:quan_tri'];
$quanTriTruongBan = ['auth', 'checkRole:quan_tri,truong_ban'];
$fullAccess = ['auth', 'checkRole:quan_tri,truong_ban,thanh_vien'];

// ==== Auth Routes ====
Route::get('/', fn() => redirect()->route('login'));
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ==== Dashboard ====
Route::middleware($quanTri)->get('/trang-chu', fn() => view('dashboard'))->name('dashboard');

// ==== Quản lý Tín Hữu ====
require __DIR__ . '/quan_ly/tin_huu.php';

// ==== Quản lý Người Dùng & Hộ Gia Đình ====
Route::resource('nguoi-dung', NguoiDungController::class)->names('nguoi_dung');
Route::resource('ho-gia-dinh', HoGiaDinhController::class)->names('_ho_gia_dinh');

// ==== Quản lý Diễn Giả ====
Route::prefix('dien-gia')->name('_dien_gia.')->group(function () {
    Route::get('/', [DienGiaController::class, 'index'])->name('index');
    Route::get('/create', [DienGiaController::class, 'create'])->name('create');
    Route::get('/{dienGia}/edit', [DienGiaController::class, 'edit'])->name('edit');
    Route::get('/{dienGia}', [DienGiaController::class, 'show'])->name('show');
});

Route::prefix('api/dien-gia')->name('api.dien_gia.')->group(function () {
    Route::get('/', [DienGiaController::class, 'getDienGias'])->name('list');
    Route::get('/{dienGia}', [DienGiaController::class, 'getDienGiaJson'])->name('details');
    Route::post('/', [DienGiaController::class, 'store'])->name('store');
    Route::put('/{dienGia}', [DienGiaController::class, 'update'])->name('update');
    Route::delete('/{dienGia}', [DienGiaController::class, 'destroy'])->name('destroy');
});

// ==== Quản lý Thân Hữu / Thiết Bị ====
Route::prefix('quan-ly-than-huu')->middleware($quanTriTruongBan)->group(function () {
    Route::resource('than-huu', ThanHuuController::class)->names('_than_huu');
});
Route::prefix('quan-ly-thiet-bi')->middleware($quanTriTruongBan)->group(function () {
    Route::resource('thiet-bi', ThietBiController::class)->names('_thiet_bi');
    Route::get('bao-cao-thiet-bi', [ThietBiController::class, 'baoCao'])->name('_thiet_bi.bao_cao');
    Route::get('thanh-ly-thiet-bi', [ThietBiController::class, 'thanhLy'])->name('_thiet_bi.thanh_ly');
});

// ==== Quản lý Tài Chính ====
Route::prefix('quan-ly-tai-chinh')->middleware($quanTri)->group(function () {
    Route::get('bao-cao-tai-chinh', [TaiChinhController::class, 'baoCao'])->name('_tai_chinh.bao_cao');
    Route::resource('thu-chi', TaiChinhController::class)->names('_thu_chi');
});

// ==== Quản lý Thờ Phượng ====
Route::prefix('quan-ly-tho-phuong')->middleware($fullAccess)->group(function () {
    Route::get('danh-sach-buoi-nhom', [ThoPhuongController::class, 'danhSachBuoiNhom'])->name('_tho_phuong.buoi_nhom');
    Route::get('danh-sach-ngay-le', [ThoPhuongController::class, 'danhSachNgayLe'])->name('_tho_phuong.ngay_le');
    Route::get('them-buoi-nhom', [ThoPhuongController::class, 'create'])->name('_tho_phuong.create');
});

// ==== Quản lý Tài Liệu ====
Route::prefix('quan-ly-tai-lieu')->middleware($quanTriTruongBan)->group(function () {
    Route::resource('tai-lieu', TaiLieuController::class)->names('_tai_lieu');
});

// ==== Thông Báo ====
Route::get('quan-ly-thong-bao/thong-bao', [ThongBaoController::class, 'index'])
    ->middleware($quanTriTruongBan)
    ->name('_thong_bao.index');

// ==== Cài Đặt ====
Route::get('cai-dat/cai-dat-he-thong', [CaiDatController::class, 'index'])->middleware($quanTri)->name('_cai_dat.he_thong');

// ==== Buổi Nhóm ====
Route::prefix('buoi-nhom')->name('buoi_nhom.')->group(function () {
    Route::get('/', [BuoiNhomController::class, 'index'])->name('index');
    Route::get('/create', [BuoiNhomController::class, 'create'])->name('create');
    Route::get('/{buoi_nhom}/edit', [BuoiNhomController::class, 'edit'])->name('edit');
    Route::get('/filter', [BuoiNhomController::class, 'filter'])->name('filter');
});

Route::prefix('api/buoi-nhom')->name('api.buoi_nhom.')->group(function () {
    Route::get('/', [BuoiNhomController::class, 'getBuoiNhoms'])->name('list');
    Route::get('/{buoi_nhom}', [BuoiNhomController::class, 'getBuoiNhomJson'])->name('details');
    Route::post('/', [BuoiNhomController::class, 'store'])->name('store');
    Route::put('/{buoi_nhom}', [BuoiNhomController::class, 'update'])->name('update');
    Route::delete('/{buoi_nhom}', [BuoiNhomController::class, 'destroy'])->name('destroy');
    Route::put('/{buoi_nhom}/update-counts', [BuoiNhomController::class, 'updateCounts'])->name('update_counts');
});

Route::get('/api/tin-huu/by-ban-nganh/{ban_nganh_id}', [BuoiNhomController::class, 'getTinHuuByBanNganh'])
    ->name('api.tin_huu.by_ban_nganh');


// Include router của từng ban ngành
require __DIR__ . '/quan_ly/tin_huu.php';
require __DIR__ . '/ban_nganh/ban_nganh.php';
//require __DIR__ . '/ban_nganh/ban_trung_lao.php';
//require __DIR__ . '/ban_nganh/ban_co_doc_giao_duc.php';
//require __DIR__ . '/ban_nganh/ban_thanh_trang.php';
require __DIR__ . '/tai_chinh/tai_chinh.php';
require __DIR__ . '/quan_ly/thiet_bi.php';
require __DIR__ . '/quan_ly/thong_bao.php';
