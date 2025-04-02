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
use App\Http\Controllers\HoGiaDinhController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NguoiDungController;
use App\Models\HoGiaDinh;
use App\Models\NguoiDung;
use App\Models\TinHuu;
use App\Models\User;
use App\Http\Controllers\AuthController;


Route::get('/', function () {
    return view('dashboard');
});
Route::get('/template', function () {
    return view('template');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');


Route::resource('nguoi-dung', NguoiDungController::class)->names([
    'index' => 'nguoi_dung.index',
    'create' => 'nguoi_dung.create',
    'store' => 'nguoi_dung.store',
    'show' => 'nguoi_dung.show',
    'edit' => 'nguoi_dung.edit',
    'update' => 'nguoi_dung.update',
    'destroy' => 'nguoi_dung.destroy',
]);

Route::resource('tin-huu', TinHuuController::class)->names([
    'index' => '_tin_huu.index',
    'create' => '_tin_huu.create',
    'store' => '_tin_huu.store',
    'show' => '_tin_huu.show',
    'edit' => '_tin_huu.edit',
    'update' => '_tin_huu.update',
    'destroy' => '_tin_huu.destroy',
]);
Route::get('danh-sach-nhan-su', [TinHuuController::class, 'danhSachNhanSu'])->name('_tin_huu.nhan_su');


Route::resource('ho-gia-dinh', HoGiaDinhController::class)->names([
    'index' => '_ho_gia_dinh.index',
    'create' => '_ho_gia_dinh.create',
    'store' => '_ho_gia_dinh.store',
    'show' => '_ho_gia_dinh.show',
    'edit' => '_ho_gia_dinh.edit',
    'update' => '_ho_gia_dinh.update',
    'destroy' => '_ho_gia_dinh.destroy',
]);

// Route::prefix('quan-ly-tin-huu')->middleware('checkRole:quan_tri,truong_ban')->group(function () {
//     Route::resource('tin-huu', TinHuuController::class)->names([
//         'index' => '_tin_huu.index',
//         'create' => '_tin_huu.create',
//         'store' => '_tin_huu.store',
//         'show' => '_tin_huu.show',
//         'edit' => '_tin_huu.edit',
//         'update' => '_tin_huu.update',
//         'destroy' => '_tin_huu.destroy',
//     ]);
//     Route::get('danh-sach-nhan-su', [TinHuuController::class, 'danhSachNhanSu'])->name('_tin_huu.nhan_su');
// });












Route::prefix('quan-ly-ban-nganh')->group(function () {
    Route::resource('ban-chap-su', BanChapSuController::class)->names([
        'index' => '_ban_chap_su.index',
        'create' => '_ban_chap_su.create',
        'store' => '_ban_chap_su.store',
        'show' => '_ban_chap_su.show',
        'edit' => '_ban_chap_su.edit',
        'update' => '_ban_chap_su.update',
        'destroy' => '_ban_chap_su.destroy',
    ]);

    Route::prefix('ban-muc-vu')->group(function () {
        Route::resource('ban-am-thuc', BanAmThucController::class)->names([
            'index' => '_ban_am_thuc.index',
            'create' => '_ban_am_thuc.create',
            'store' => '_ban_am_thuc.store',
            'show' => '_ban_am_thuc.show',
            'edit' => '_ban_am_thuc.edit',
            'update' => '_ban_am_thuc.update',
            'destroy' => '_ban_am_thuc.destroy',
        ]);
        Route::resource('ban-cau-nguyen', BanCauNguyenController::class)->names([
            'index' => '_ban_cau_nguyen.index',
            'create' => '_ban_cau_nguyen.create',
            'store' => '_ban_cau_nguyen.store',
            'show' => '_ban_cau_nguyen.show',
            'edit' => '_ban_cau_nguyen.edit',
            'update' => '_ban_cau_nguyen.update',
            'destroy' => '_ban_cau_nguyen.destroy',
        ]);
        Route::resource('ban-chung-dao', BanChungDaoController::class)->names([
            'index' => '_ban_chung_dao.index',
            'create' => '_ban_chung_dao.create',
            'store' => '_ban_chung_dao.store',
            'show' => '_ban_chung_dao.show',
            'edit' => '_ban_chung_dao.edit',
            'update' => '_ban_chung_dao.update',
            'destroy' => '_ban_chung_dao.destroy',
        ]);
        Route::resource('ban-co-doc-giao-duc', BanCoDocGiaoDucController::class)->names([
            'index' => '_ban_co_doc_giao_duc.index',
            'create' => '_ban_co_doc_giao_duc.create',
            'store' => '_ban_co_doc_giao_duc.store',
            'show' => '_ban_co_doc_giao_duc.show',
            'edit' => '_ban_co_doc_giao_duc.edit',
            'update' => '_ban_co_doc_giao_duc.update',
            'destroy' => '_ban_co_doc_giao_duc.destroy',
        ]);
        Route::resource('ban-dan', BanDanController::class)->names([
            'index' => '_ban_dan.index',
            'create' => '_ban_dan.create',
            'store' => '_ban_dan.store',
            'show' => '_ban_dan.show',
            'edit' => '_ban_dan.edit',
            'update' => '_ban_dan.update',
            'destroy' => '_ban_dan.destroy',
        ]);
        Route::resource('ban-hau-can', BanHauCanController::class)->names([
            'index' => '_ban_hau_can.index',
            'create' => '_ban_hau_can.create',
            'store' => '_ban_hau_can.store',
            'show' => '_ban_hau_can.show',
            'edit' => '_ban_hau_can.edit',
            'update' => '_ban_hau_can.update',
            'destroy' => '_ban_hau_can.destroy',
        ]);
        Route::resource('ban-hat-tho-phuong', BanHatThoPhuongController::class)->names([
            'index' => '_ban_hat_tho_phuong.index',
            'create' => '_ban_hat_tho_phuong.create',
            'store' => '_ban_hat_tho_phuong.store',
            'show' => '_ban_hat_tho_phuong.show',
            'edit' => '_ban_hat_tho_phuong.edit',
            'update' => '_ban_hat_tho_phuong.update',
            'destroy' => '_ban_hat_tho_phuong.destroy',
        ]);
        Route::resource('ban-khanh-tiet', BanKhanhTietController::class)->names([
            'index' => '_ban_khanh_tiet.index',
            'create' => '_ban_khanh_tiet.create',
            'store' => '_ban_khanh_tiet.store',
            'show' => '_ban_khanh_tiet.show',
            'edit' => '_ban_khanh_tiet.edit',
            'update' => '_ban_khanh_tiet.update',
            'destroy' => '_ban_khanh_tiet.destroy',
        ]);
        Route::resource('ban-ky-thuat-am-thanh', BanKyThuatAmThanhController::class)->names([
            'index' => '_ban_ky_thuat_am_thanh.index',
            'create' => '_ban_ky_thuat_am_thanh.create',
            'store' => '_ban_ky_thuat_am_thanh.store',
            'show' => '_ban_ky_thuat_am_thanh.show',
            'edit' => '_ban_ky_thuat_am_thanh.edit',
            'update' => '_ban_ky_thuat_am_thanh.update',
            'destroy' => '_ban_ky_thuat_am_thanh.destroy',
        ]);
        Route::resource('ban-le-tan', BanLeTanController::class)->names([
            'index' => '_ban_le_tan.index',
            'create' => '_ban_le_tan.create',
            'store' => '_ban_le_tan.store',
            'show' => '_ban_le_tan.show',
            'edit' => '_ban_le_tan.edit',
            'update' => '_ban_le_tan.update',
            'destroy' => '_ban_le_tan.destroy',
        ]);
        Route::resource('ban-may-chieu', BanMayChieuController::class)->names([
            'index' => '_ban_may_chieu.index',
            'create' => '_ban_may_chieu.create',
            'store' => '_ban_may_chieu.store',
            'show' => '_ban_may_chieu.show',
            'edit' => '_ban_may_chieu.edit',
            'update' => '_ban_may_chieu.update',
            'destroy' => '_ban_may_chieu.destroy',
        ]);
        Route::resource('ban-tham-vieng', BanThamViengController::class)->names([
            'index' => '_ban_tham_vieng.index',
            'create' => '_ban_tham_vieng.create',
            'store' => '_ban_tham_vieng.store',
            'show' => '_ban_tham_vieng.show',
            'edit' => '_ban_tham_vieng.edit',
            'update' => '_ban_tham_vieng.update',
            'destroy' => '_ban_tham_vieng.destroy',
        ]);
        Route::resource('ban-trat-tu', BanTratTuController::class)->names([
            'index' => '_ban_trat_tu.index',
            'create' => '_ban_trat_tu.create',
            'store' => '_ban_trat_tu.store',
            'show' => '_ban_trat_tu.show',
            'edit' => '_ban_trat_tu.edit',
            'update' => '_ban_trat_tu.update',
            'destroy' => '_ban_trat_tu.destroy',
        ]);
        Route::resource('ban-truyen-giang', BanTruyenGiangController::class)->names([
            'index' => '_ban_truyen_giang.index',
            'create' => '_ban_truyen_giang.create',
            'store' => '_ban_truyen_giang.store',
            'show' => '_ban_truyen_giang.show',
            'edit' => '_ban_truyen_giang.edit',
            'update' => '_ban_truyen_giang.update',
            'destroy' => '_ban_truyen_giang.destroy',
        ]);
        Route::resource('ban-truyen-thong-may-chieu', BanTruyenThongMayChieuController::class)->names([
            'index' => '_ban_truyen_thong_may_chieu.index',
            'create' => '_ban_truyen_thong_may_chieu.create',
            'store' => '_ban_truyen_thong_may_chieu.store',
            'show' => '_ban_truyen_thong_may_chieu.show',
            'edit' => '_ban_truyen_thong_may_chieu.edit',
            'update' => '_ban_truyen_thong_may_chieu.update',
            'destroy' => '_ban_truyen_thong_may_chieu.destroy',
        ]);
    });
    Route::prefix('ban-nganh')->group(function () {
        Route::resource('ban-thanh-nien', BanThanhNienController::class)->names([
            'index' => '_ban_thanh_nien.index',
            'create' => '_ban_thanh_nien.create',
            'store' => '_ban_thanh_nien.store',
            'show' => '_ban_thanh_nien.show',
            'edit' => '_ban_thanh_nien.edit',
            'update' => '_ban_thanh_nien.update',
            'destroy' => '_ban_thanh_nien.destroy',
        ]);
        Route::resource('ban-thanh-trang', BanThanhTrangController::class)->names([
            'index' => '_ban_thanh_trang.index',
            'create' => '_ban_thanh_trang.create',
            'store' => '_ban_thanh_trang.store',
            'show' => '_ban_thanh_trang.show',
            'edit' => '_ban_thanh_trang.edit',
            'update' => '_ban_thanh_trang.update',
            'destroy' => '_ban_thanh_trang.destroy',
        ]);
        Route::resource('ban-thieu-nhi-au', BanThieuNhiAuController::class)->names([
            'index' => '_ban_thieu_nhi_au.index',
            'create' => '_ban_thieu_nhi_au.create',
            'store' => '_ban_thieu_nhi_au.store',
            'show' => '_ban_thieu_nhi_au.show',
            'edit' => '_ban_thieu_nhi_au.edit',
            'update' => '_ban_thieu_nhi_au.update',
            'destroy' => '_ban_thieu_nhi_au.destroy',
        ]);
        Route::resource('ban-trung-lao', BanTrungLaoController::class)->names([
            'index' => '_ban_trung_lao.index',
            'create' => '_ban_trung_lao.create',
            'store' => '_ban_trung_lao.store',
            'show' => '_ban_trung_lao.show',
            'edit' => '_ban_trung_lao.edit',
            'update' => '_ban_trung_lao.update',
            'destroy' => '_ban_trung_lao.destroy',
        ]);
    });
});

// Quản lý Tín Hữu
Route::prefix('quan-ly-tin-huu')->group(function () {
    Route::get('danh-sach-tin-huu', [TinHuuController::class, 'index'])->name('_tin_huu.index');
    Route::get('them-tin-huu', [TinHuuController::class, 'create'])->name('_tin_huu.create');
    Route::get('danh-sach-nhan-su', [TinHuuController::class, 'danhSachNhanSu'])->name('_tin_huu.nhan_su');
    Route::get('thong-tin-tin-huu/{id}', [TinHuuController::class, 'show'])->name('_tin_huu.show');
});

// Quản lý Diễn Giả
Route::prefix('quan-ly-dien-gia')->group(function () {
    Route::resource('dien-gia', DienGiaController::class)->names([
        'index' => '_dien_gia.index',
        'create' => '_dien_gia.create',
        'store' => '_dien_gia.store',
        'show' => '_dien_gia.show',
        'edit' => '_dien_gia.edit',
        'update' => '_dien_gia.update',
        'destroy' => '_dien_gia.destroy',
    ]);
});

// Quản lý Thân Hữu
Route::prefix('quan-ly-than-huu')->group(function () {
    Route::resource('than-huu', ThanHuuController::class)->names([
        'index' => '_than_huu.index',
        'create' => '_than_huu.create',
        'store' => '_than_huu.store',
        'show' => '_than_huu.show',
        'edit' => '_than_huu.edit',
        'update' => '_than_huu.update',
        'destroy' => '_than_huu.destroy',
    ]);
});

// Quản lý Thiết bị
Route::prefix('quan-ly-thiet-bi')->group(function () {
    Route::resource('thiet-bi', ThietBiController::class)->names([
        'index' => '_thiet_bi.index',
        'create' => '_thiet_bi.create',
        'store' => '_thiet_bi.store',
        'show' => '_thiet_bi.show',
        'edit' => '_thiet_bi.edit',
        'update' => '_thiet_bi.update',
        'destroy' => '_thiet_bi.destroy',
    ]);
    Route::get('bao-cao-thiet-bi', [ThietBiController::class, 'baoCao'])->name('_thiet_bi.bao_cao');
    Route::get('thanh-ly-thiet-bi', [ThietBiController::class, 'thanhLy'])->name('_thiet_bi.thanh_ly');
});

// Quản lý Tài Chính
Route::prefix('quan-ly-tai-chinh')->group(function () {
    Route::get('bao-cao-tai-chinh', [TaiChinhController::class, 'baoCao'])->name('_tai_chinh.bao_cao');
    Route::resource('thu-chi', TaiChinhController::class)->names([
        'index' => '_thu_chi.index',
        'create' => '_thu_chi.create',
        'store' => '_thu_chi.store',
        'show' => '_thu_chi.show',
        'edit' => '_thu_chi.edit',
        'update' => '_thu_chi.update',
        'destroy' => '_thu_chi.destroy',
    ]);
});

// Quản lý Thờ Phượng
Route::prefix('quan-ly-tho-phuong')->group(function () {
    Route::get('danh-sach-buoi-nhom', [ThoPhuongController::class, 'danhSachBuoiNhom'])->name('_tho_phuong.buoi_nhom');
    Route::get('danh-sach-ngay-le', [ThoPhuongController::class, 'danhSachNgayLe'])->name('_tho_phuong.ngay_le');
    Route::get('them-buoi-nhom', [ThoPhuongController::class, 'create'])->name('_tho_phuong.create');
});

// Quản lý Tài liệu
Route::prefix('quan-ly-tai-lieu')->group(function () {
    Route::resource('tai-lieu', TaiLieuController::class)->names([
        'index' => '_tai_lieu.index',
        'create' => '_tai_lieu.create',
        'store' => '_tai_lieu.store',
        'show' => '_tai_lieu.show',
        'edit' => '_tai_lieu.edit',
        'update' => '_tai_lieu.update',
        'destroy' => '_tai_lieu.destroy',
    ]);
});

// Quản lý Thông báo
Route::get('quan-ly-thong-bao/thong-bao', [ThongBaoController::class, 'index'])->name('_thong_bao.index');

// Báo cáo
Route::prefix('bao-cao')->group(function () {
    Route::get('bao-cao-tho-phuong', [BaoCaoController::class, 'baoCaoThoPhuong'])->name('_bao_cao.tho_phuong');
    Route::get('bao-cao-thiet-bi', [BaoCaoController::class, 'baoCaoThietBi'])->name('_bao_cao.thiet_bi');
    Route::get('bao-cao-tai-chinh', [BaoCaoController::class, 'baoCaoTaiChinh'])->name('_bao_cao.tai_chinh');
    Route::get('bao-cao-ban-nganh', [BaoCaoController::class, 'baoCaoBanNganh'])->name('_bao_cao.ban_nganh');
});

// Cài đặt
Route::get('cai-dat/cai-dat-he-thong', [CaiDatController::class, 'index'])->name('_cai_dat.he_thong');



// Quản lý Diễn Giả (Chỉ cho quản trị viên)
// Route::prefix('quan-ly-dien-gia')->middleware('checkRole:quan_tri')->group(function () {
//     Route::resource('dien-gia', DienGiaController::class)->names([
//         'index' => 'dien-gia.index',
//         'create' => 'dien-gia.create',
//         'store' => 'dien-gia.store',
//         'show' => 'dien-gia.show',
//         'edit' => 'dien-gia.edit',
//         'update' => 'dien-gia.update',
//         'destroy' => 'dien-gia.destroy',
//     ]);
// });

// Quản lý Thân Hữu (Quản trị viên và trưởng ban)
// Route::prefix('quan-ly-than-huu')->middleware('checkRole:quan_tri,truong_ban')->group(function () {
//     Route::resource('than-huu', ThanHuuController::class)->names([
//         'index' => 'than-huu.index',
//         'create' => 'than-huu.create',
//         'store' => 'than-huu.store',
//         'show' => 'than-huu.show',
//         'edit' => 'than-huu.edit',
//         'update' => 'than-huu.update',
//         'destroy' => 'than-huu.destroy',
//     ]);
// });

// Quản lý Thiết bị (Quản trị viên và trưởng ban)
// Route::prefix('quan-ly-thiet-bi')->middleware('checkRole:quan_tri,truong_ban')->group(function () {
//     Route::resource('thiet-bi', ThietBiController::class)->names([
//         'index' => 'thiet-bi.index',
//         'create' => 'thiet-bi.create',
//         'store' => 'thiet-bi.store',
//         'show' => 'thiet-bi.show',
//         'edit' => 'thiet-bi.edit',
//         'update' => 'thiet-bi.update',
//         'destroy' => 'thiet-bi.destroy',
//     ]);
//     Route::get('bao-cao-thiet-bi', [ThietBiController::class, 'baoCao'])->name('thiet-bi.bao_cao');
//     Route::get('thanh-ly-thiet-bi', [ThietBiController::class, 'thanhLy'])->name('thiet-bi.thanh_ly');
// });

// Quản lý Tài Chính (Chỉ quản trị viên)
// Route::prefix('quan-ly-tai-chinh')->middleware('checkRole:quan_tri')->group(function () {
//     Route::get('bao-cao-tai-chinh', [TaiChinhController::class, 'baoCao'])->name('tai-chinh.bao_cao');
//     Route::resource('thu-chi', TaiChinhController::class)->names([
//         'index' => 'thu-chi.index',
//         'create' => 'thu-chi.create',
//         'store' => 'thu-chi.store',
//         'show' => 'thu-chi.show',
//         'edit' => 'thu-chi.edit',
//         'update' => 'thu-chi.update',
//         'destroy' => 'thu-chi.destroy',
//     ]);
// });

// Quản lý Thờ Phượng (Quản trị viên, trưởng ban, thành viên)
// Route::prefix('quan-ly-tho-phuong')->middleware('checkRole:quan_tri,truong_ban,thanh_vien')->group(function () {
//    Route::resource('tho-phuong', ThoPhuongController::class)->names([
//         'index' => 'tho-phuong.index',
//         'create' => 'tho-phuong.create',
//         'store' => 'tho-phuong.store',
//         'show' => 'tho-phuong.show',
//         'edit' => 'tho-phuong.edit',
//         'update' => 'tho-phuong.update',
//         'destroy' => 'tho-phuong.destroy',
//     ]);
// });

// Quản lý Tài liệu (Quản trị viên và trưởng ban)
// Route::prefix('quan-ly-tai-lieu')->middleware('checkRole:quan_tri,truong_ban')->group(function () {
//     Route::resource('tai-lieu', TaiLieuController::class)->names([
//         'index' => 'tai-lieu.index',
//         'create' => 'tai-lieu.create',
//         'store' => 'tai-lieu.store',
//         'show' => 'tai-lieu.show',
//         'edit' => 'tai-lieu.edit',
//         'update' => 'tai-lieu.update',
//         'destroy' => 'tai-lieu.destroy',
//     ]);
// });

// Quản lý Thông báo (Quản trị viên và trưởng ban)
// Route::get('quan-ly-thong-bao/thong-bao', [ThongBaoController::class, 'index'])->middleware('checkRole:quan_tri,truong_ban')->name('thong-bao.index');

// Báo cáo (Chỉ quản trị viên)
// Route::prefix('bao-cao')->middleware('checkRole:quan_tri')->group(function () {
//     Route::get('bao-cao-tho-phuong', [BaoCaoController::class, 'baoCaoThoPhuong'])->name('bao-cao.tho_phuong');
//     Route::get('bao-cao-thiet-bi', [BaoCaoController::class, 'baoCaoThietBi'])->name('bao-cao.thiet_bi');
//     Route::get('bao-cao-tai-chinh', [BaoCaoController::class, 'baoCaoTaiChinh'])->name('bao-cao.tai_chinh');
//     Route::get('bao-cao-ban-nganh', [BaoCaoController::class, 'baoCaoBanNganh'])->name('bao-cao.ban_nganh');
// });

// Cài đặt (Chỉ quản trị viên)
// Route::get('cai-dat/cai-dat-he-thong', [CaiDatController::class, 'index'])->middleware('checkRole:quan_tri')->name('cai-dat.he_thong');

// Quản lý Người Dùng (Chỉ quản trị viên)
// Route::prefix('quan-ly-nguoi-dung')->middleware('checkRole:quan_tri')->group(function () {
    
// });