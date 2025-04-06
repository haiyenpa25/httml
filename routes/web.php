<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController, TinHuuController, HoGiaDinhController, NguoiDungController,
    BanChapSuController, BanAmThucController, BanCauNguyenController, BanChungDaoController,
    BanCoDocGiaoDucController, BanDanController, BanHauCanController, BanHatThoPhuongController,
    BanKhanhTietController, BanKyThuatAmThanhController, BanLeTanController, BanMayChieuController,
    BanThamViengController, BanTratTuController, BanTruyenGiangController, BanTruyenThongMayChieuController,
    BanThanhNienController, BanThanhTrangController, BanThieuNhiAuController, BanTrungLaoController,
    DienGiaController, ThanHuuController, ThietBiController, TaiChinhController,
    ThoPhuongController, TaiLieuController, ThongBaoController, BaoCaoController,
    CaiDatController, BanNganhController
};

// ==== Middleware groups ====
$quanTri = ['auth', 'checkRole:quan_tri'];
$quanTriTruongBan = ['auth', 'checkRole:quan_tri,truong_ban'];
$fullAccess = ['auth', 'checkRole:quan_tri,truong_ban,thanh_vien'];

// ==== Auth Routes ====
Route::get('/', fn () => redirect()->route('login'));
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ==== Dashboard ====
Route::middleware($quanTri)->get('/trang-chu', fn () => view('dashboard'))->name('dashboard');

// ==== Quản lý Tín Hữu ====
Route::prefix('quan-ly-tin-huu')->middleware($quanTriTruongBan)->group(function () {
    Route::resource('tin-huu', TinHuuController::class)->names('_tin_huu');
    Route::get('danh-sach-nhan-su', [TinHuuController::class, 'danhSachNhanSu'])->name('_tin_huu.nhan_su');
});

// ==== Quản lý Người Dùng & Hộ Gia Đình ====
Route::resource('nguoi-dung', NguoiDungController::class)->names('nguoi_dung');
Route::resource('ho-gia-dinh', HoGiaDinhController::class)->names('_ho_gia_dinh');

// ==== Quản lý Ban Ngành ====
Route::prefix('quan-ly-ban-nganh')->middleware($quanTriTruongBan)->group(function () {
    // Danh sách ban ngành tổng hợp
    Route::resource('danh-sach', BanNganhController::class)->names('_ban_nganh');

    // Ban chấp sự riêng
    Route::resource('ban-chap-su', BanChapSuController::class)->names('_ban_chap_su');

    // Các ban mục vụ
    Route::prefix('ban-muc-vu')->group(function () {
        Route::resource('ban-am-thuc', BanAmThucController::class)->names('_ban_am_thuc');
        Route::resource('ban-cau-nguyen', BanCauNguyenController::class)->names('_ban_cau_nguyen');
        Route::resource('ban-chung-dao', BanChungDaoController::class)->names('_ban_chung_dao');
        Route::resource('ban-co-doc-giao-duc', BanCoDocGiaoDucController::class)->names('_ban_co_doc_giao_duc');
        Route::resource('ban-dan', BanDanController::class)->names('_ban_dan');
        Route::resource('ban-hau-can', BanHauCanController::class)->names('_ban_hau_can');
        Route::resource('ban-hat-tho-phuong', BanHatThoPhuongController::class)->names('_ban_hat_tho_phuong');
        Route::resource('ban-khanh-tiet', BanKhanhTietController::class)->names('_ban_khanh_tiet');
        Route::resource('ban-ky-thuat-am-thanh', BanKyThuatAmThanhController::class)->names('_ban_ky_thuat_am_thanh');
        Route::resource('ban-le-tan', BanLeTanController::class)->names('_ban_le_tan');
        Route::resource('ban-may-chieu', BanMayChieuController::class)->names('_ban_may_chieu');
        Route::resource('ban-tham-vieng', BanThamViengController::class)->names('_ban_tham_vieng');
        Route::resource('ban-trat-tu', BanTratTuController::class)->names('_ban_trat_tu');
        Route::resource('ban-truyen-giang', BanTruyenGiangController::class)->names('_ban_truyen_giang');
        Route::resource('ban-truyen-thong-may-chieu', BanTruyenThongMayChieuController::class)->names('_ban_truyen_thong_may_chieu');
    });

    // Các ban ngành khác
    Route::prefix('ban-nganh')->group(function () {
        Route::resource('ban-thanh-nien', BanThanhNienController::class)->names('_ban_thanh_nien');
        Route::resource('ban-thanh-trang', BanThanhTrangController::class)->names('_ban_thanh_trang');
        Route::resource('ban-thieu-nhi-au', BanThieuNhiAuController::class)->names('_ban_thieu_nhi_au');
        Route::resource('ban-trung-lao', BanTrungLaoController::class)->names('_ban_trung_lao');
    });
});

// ==== Quản lý Diễn Giả / Thân Hữu / Thiết Bị ====
Route::prefix('quan-ly-dien-gia')->middleware($quanTri)->group(function () {
    Route::resource('dien-gia', DienGiaController::class)
        ->names('_dien_gia')
        ->parameters(['dien-gia' => 'dienGia']);
});

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

// ==== Báo Cáo ====
Route::prefix('bao-cao')->middleware($quanTri)->group(function () {
    Route::get('bao-cao-tho-phuong', [BaoCaoController::class, 'baoCaoThoPhuong'])->name('_bao_cao.tho_phuong');
    Route::get('bao-cao-thiet-bi', [BaoCaoController::class, 'baoCaoThietBi'])->name('_bao_cao.thiet_bi');
    Route::get('bao-cao-tai-chinh', [BaoCaoController::class, 'baoCaoTaiChinh'])->name('_bao_cao.tai_chinh');
    Route::get('bao-cao-ban-nganh', [BaoCaoController::class, 'baoCaoBanNganh'])->name('_bao_cao.ban_nganh');
    Route::get('bao-cao-hoi-thanh', [BaoCaoController::class, 'baoCaoHoiThanh'])->name('_bao_cao.hoi_thanh');
    Route::get('bao-cao-ban-trung-lao', [BaoCaoController::class, 'baoCaoBanTrungLao'])->name('_bao_cao.ban_trung_lao');

    Route::get('bao-cao-ban-thanh-nien', [BaoCaoController::class, 'baoCaoBanThanhNien'])->name('_bao_cao.ban_thanh_nien');
});

// ==== Cài Đặt ====
Route::get('cai-dat/cai-dat-he-thong', [CaiDatController::class, 'index'])->middleware($quanTri)->name('_cai_dat.he_thong');


