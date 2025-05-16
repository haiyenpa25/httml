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
    BanMucVu\BanMucVuThanhVienController,
    NguoiDungPhanQuyenController,
    TrangChuController
};

// ==== Auth Routes ====
Route::get('/', fn() => redirect()->route('login'));
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/trang-chu', [App\Http\Controllers\TrangChuController::class, 'index'])->name('trang-chu');
Route::get('/trang-chu2', [TrangChuController::class, 'index'])->name('dashboard');

// ==== Dashboard ====
// Route::middleware(['auth'])->get('/trang-chu', fn() => view('dashboard'))
//     ->middleware('checkPermission:view-dashboard')
//     ->name('dashboard');



// Quản lý Phân Quyền Người Dùng
Route::prefix('quan-ly-phan-quyen')->middleware(['auth'])->group(function () {
    // Trang chính quản lý phân quyền, hiển thị danh sách người dùng
    Route::get('/', [NguoiDungPhanQuyenController::class, 'index'])
        ->middleware('checkPermission:manage-phan-quyen')
        ->name('_phan_quyen.index');

    // Trang phân quyền cho người dùng cụ thể
    Route::get('/user/{userId}', [NguoiDungPhanQuyenController::class, 'showUserPermissions'])
        ->middleware('checkPermission:manage-phan-quyen')
        ->name('_phan_quyen.user');

    // Lấy quyền theo vai trò (dùng cho AJAX)
    Route::get('/role-permissions', [NguoiDungPhanQuyenController::class, 'getRolePermissions'])
        ->middleware('checkPermission:manage-phan-quyen')
        ->name('_phan_quyen.role_permissions');

    // Cập nhật vai trò người dùng
    Route::post('/update-role/{userId}', [NguoiDungPhanQuyenController::class, 'updateRole'])
        ->middleware('checkPermission:manage-phan-quyen')
        ->name('_phan_quyen.update_role');

    // Lấy danh sách quyền của người dùng (dùng cho AJAX)
    Route::get('/user-permissions/{userId}', [NguoiDungPhanQuyenController::class, 'getUserPermissions'])
        ->middleware('checkPermission:manage-phan-quyen')
        ->name('_phan_quyen.get_user_permissions');

    // Cập nhật quyền người dùng
    Route::post('/update-permissions/{userId}', [NguoiDungPhanQuyenController::class, 'updateUserPermissions'])
        ->middleware('checkPermission:manage-phan-quyen')
        ->name('_phan_quyen.update_permissions');

    // Lấy danh sách default_url của người dùng
    Route::get('/user-default-urls/{userId}', [NguoiDungPhanQuyenController::class, 'getUserDefaultUrls'])
        ->middleware('checkPermission:manage-phan-quyen')
        ->name('_phan_quyen.get_user_default_urls');

    // Cập nhật default_url của người dùng
    Route::post('/update-default-url/{userId}', [NguoiDungPhanQuyenController::class, 'updateDefaultUrl'])
        ->middleware('checkPermission:manage-phan-quyen')
        ->name('_phan_quyen.update_default_url');
});


// ==== Quản lý Tín Hữu ====
require __DIR__ . '/quan_ly/tin_huu.php';

// ==== Quản lý Người Dùng & Hộ Gia Đình ====
Route::prefix('nguoi-dung')->middleware(['auth'])->group(function () {
    Route::get('/', [NguoiDungController::class, 'index'])
        ->middleware('checkPermission:view-nguoi-dung')
        ->name('nguoi_dung.index');
    Route::get('/create', [NguoiDungController::class, 'create'])
        ->middleware('checkPermission:create-nguoi-dung')
        ->name('nguoi_dung.create');
    Route::post('/', [NguoiDungController::class, 'store'])
        ->middleware('checkPermission:create-nguoi-dung')
        ->name('nguoi_dung.store');
    Route::get('/{nguoiDung}', [NguoiDungController::class, 'show'])
        ->middleware('checkPermission:view-nguoi-dung')
        ->name('nguoi_dung.show');
    Route::get('/{nguoiDung}/edit', [NguoiDungController::class, 'edit'])
        ->middleware('checkPermission:update-nguoi-dung')
        ->name('nguoi_dung.edit');
    Route::put('/{nguoiDung}', [NguoiDungController::class, 'update'])
        ->middleware('checkPermission:update-nguoi-dung')
        ->name('nguoi_dung.update');
    Route::delete('/{nguoiDung}', [NguoiDungController::class, 'destroy'])
        ->middleware('checkPermission:delete-nguoi-dung')
        ->name('nguoi_dung.destroy');
});

Route::prefix('ho-gia-dinh')->middleware(['auth'])->group(function () {
    Route::get('/', [HoGiaDinhController::class, 'index'])
        ->middleware('checkPermission:view-ho-gia-dinh')
        ->name('_ho_gia_dinh.index');
    Route::get('/create', [HoGiaDinhController::class, 'create'])
        ->middleware('checkPermission:create-ho-gia-dinh')
        ->name('_ho_gia_dinh.create');
    Route::post('/', [HoGiaDinhController::class, 'store'])
        ->middleware('checkPermission:create-ho-gia-dinh')
        ->name('_ho_gia_dinh.store');
    Route::get('/{hoGiaDinh}', [HoGiaDinhController::class, 'show'])
        ->middleware('checkPermission:view-ho-gia-dinh')
        ->name('_ho_gia_dinh.show');
    Route::get('/{hoGiaDinh}/edit', [HoGiaDinhController::class, 'edit'])
        ->middleware('checkPermission:update-ho-gia-dinh')
        ->name('_ho_gia_dinh.edit');
    Route::put('/{hoGiaDinh}', [HoGiaDinhController::class, 'update'])
        ->middleware('checkPermission:update-ho-gia-dinh')
        ->name('_ho_gia_dinh.update');
    Route::delete('/{hoGiaDinh}', [HoGiaDinhController::class, 'destroy'])
        ->middleware('checkPermission:delete-ho-gia-dinh')
        ->name('_ho_gia_dinh.destroy');
});


// ==== Quản lý Thân Hữu / Thiết Bị ====
Route::prefix('quan-ly-than-huu')->middleware(['auth'])->group(function () {
    Route::get('/', [ThanHuuController::class, 'index'])
        ->middleware('checkPermission:view-than-huu')
        ->name('_than_huu.index');
    Route::get('/create', [ThanHuuController::class, 'create'])
        ->middleware('checkPermission:manage-than-huu')
        ->name('_than_huu.create');
    Route::post('/', [ThanHuuController::class, 'store'])
        ->middleware('checkPermission:manage-than-huu')
        ->name('_than_huu.store');
    Route::get('/{thanHuu}', [ThanHuuController::class, 'show'])
        ->middleware('checkPermission:view-than-huu')
        ->name('_than_huu.show');
    Route::get('/{thanHuu}/edit', [ThanHuuController::class, 'edit'])
        ->middleware('checkPermission:manage-than-huu')
        ->name('_than_huu.edit');
    Route::put('/{thanHuu}', [ThanHuuController::class, 'update'])
        ->middleware('checkPermission:manage-than-huu')
        ->name('_than_huu.update');
    Route::delete('/{thanHuu}', [ThanHuuController::class, 'destroy'])
        ->middleware('checkPermission:manage-than-huu')
        ->name('_than_huu.destroy');
});

Route::prefix('quan-ly-thiet-bi')->middleware(['auth'])->group(function () {
    Route::get('/', [ThietBiController::class, 'index'])
        ->middleware('checkPermission:view-thiet-bi')
        ->name('_thiet_bi.index');
    Route::get('/create', [ThietBiController::class, 'create'])
        ->middleware('checkPermission:manage-thiet-bi')
        ->name('_thiet_bi.create');
    Route::post('/', [ThietBiController::class, 'store'])
        ->middleware('checkPermission:manage-thiet-bi')
        ->name('_thiet_bi.store');
    Route::get('/{thietBi}', [ThietBiController::class, 'show'])
        ->middleware('checkPermission:view-thiet-bi')
        ->name('_thiet_bi.show');
    Route::get('/{thietBi}/edit', [ThietBiController::class, 'edit'])
        ->middleware('checkPermission:manage-thiet-bi')
        ->name('_thiet_bi.edit');
    Route::put('/{thietBi}', [ThietBiController::class, 'update'])
        ->middleware('checkPermission:manage-thiet-bi')
        ->name('_thiet_bi.update');
    Route::delete('/{thietBi}', [ThietBiController::class, 'destroy'])
        ->middleware('checkPermission:manage-thiet-bi')
        ->name('_thiet_bi.destroy');
    Route::get('bao-cao-thiet-bi', [ThietBiController::class, 'baoCao'])
        ->middleware('checkPermission:view-thiet-bi-bao-cao')
        ->name('_thiet_bi.bao_cao');
    Route::get('thanh-ly-thiet-bi', [ThietBiController::class, 'thanhLy'])
        ->middleware('checkPermission:manage-thiet-bi')
        ->name('_thiet_bi.thanh_ly');
});

// ==== Quản lý Tài Chính ====
Route::prefix('quan-ly-tai-chinh')->middleware(['auth'])->group(function () {
    Route::get('bao-cao-tai-chinh', [TaiChinhController::class, 'baoCao'])
        ->middleware('checkPermission:view-bao-cao-tai-chinh')
        ->name('_tai_chinh.bao_cao');
    Route::get('thu-chi', [TaiChinhController::class, 'index'])
        ->middleware('checkPermission:view-tai-chinh')
        ->name('_thu_chi.index');
    Route::get('thu-chi/create', [TaiChinhController::class, 'create'])
        ->middleware('checkPermission:manage-tai-chinh')
        ->name('_thu_chi.create');
    Route::post('thu-chi', [TaiChinhController::class, 'store'])
        ->middleware('checkPermission:manage-tai-chinh')
        ->name('_thu_chi.store');
    Route::get('thu-chi/{thuChi}', [TaiChinhController::class, 'show'])
        ->middleware('checkPermission:view-tai-chinh')
        ->name('_thu_chi.show');
    Route::get('thu-chi/{thuChi}/edit', [TaiChinhController::class, 'edit'])
        ->middleware('checkPermission:manage-tai-chinh')
        ->name('_thu_chi.edit');
    Route::put('thu-chi/{thuChi}', [TaiChinhController::class, 'update'])
        ->middleware('checkPermission:manage-tai-chinh')
        ->name('_thu_chi.update');
    Route::delete('thu-chi/{thuChi}', [TaiChinhController::class, 'destroy'])
        ->middleware('checkPermission:manage-tai-chinh')
        ->name('_thu_chi.destroy');
});

// ==== Quản lý Thờ Phượng ====
Route::prefix('quan-ly-tho-phuong')->middleware(['auth'])->group(function () {
    Route::get('danh-sach-buoi-nhom', [ThoPhuongController::class, 'danhSachBuoiNhom'])
        ->middleware('checkPermission:view-tho-phuong')
        ->name('_tho_phuong.buoi_nhom');
    Route::get('danh-sach-ngay-le', [ThoPhuongController::class, 'danhSachNgayLe'])
        ->middleware('checkPermission:view-tho-phuong')
        ->name('_tho_phuong.ngay_le');
    Route::get('them-buoi-nhom', [ThoPhuongController::class, 'create'])
        ->middleware('checkPermission:manage-tho-phuong')
        ->name('_tho_phuong.create');
});

// ==== Quản lý Tài Liệu ====
Route::prefix('quan-ly-tai-lieu')->middleware(['auth'])->group(function () {
    Route::get('/', [TaiLieuController::class, 'index'])
        ->middleware('checkPermission:view-tai-lieu')
        ->name('_tai_lieu.index');
    Route::get('/create', [TaiLieuController::class, 'create'])
        ->middleware('checkPermission:manage-tai-lieu')
        ->name('_tai_lieu.create');
    Route::post('/', [TaiLieuController::class, 'store'])
        ->middleware('checkPermission:manage-tai-lieu')
        ->name('_tai_lieu.store');
    Route::get('/{taiLieu}', [TaiLieuController::class, 'show'])
        ->middleware('checkPermission:view-tai-lieu')
        ->name('_tai_lieu.show');
    Route::get('/{taiLieu}/edit', [TaiLieuController::class, 'edit'])
        ->middleware('checkPermission:manage-tai-lieu')
        ->name('_tai_lieu.edit');
    Route::put('/{taiLieu}', [TaiLieuController::class, 'update'])
        ->middleware('checkPermission:manage-tai-lieu')
        ->name('_tai_lieu.update');
    Route::delete('/{taiLieu}', [TaiLieuController::class, 'destroy'])
        ->middleware('checkPermission:manage-tai-lieu')
        ->name('_tai_lieu.destroy');
});

// ==== Thông Báo ====
Route::get('quan-ly-thong-bao/thong-bao', [ThongBaoController::class, 'index'])
    ->middleware(['auth', 'checkPermission:view-thong-bao'])
    ->name('_thong_bao.index');

// ==== Cài Đặt ====
Route::get('cai-dat/cai-dat-he-thong', [CaiDatController::class, 'index'])
    ->middleware(['auth', 'checkPermission:view-cai-dat'])
    ->name('_cai_dat.he_thong');

// ==== Buổi Nhóm ====
Route::prefix('buoi-nhom')->middleware(['auth'])->name('buoi_nhom.')->group(function () {
    Route::get('/', [BuoiNhomController::class, 'index'])
        ->middleware('checkPermission:view-buoi-nhom')
        ->name('index');
    Route::get('/create', [BuoiNhomController::class, 'create'])
        ->middleware('checkPermission:manage-buoi-nhom')
        ->name('create');
    Route::get('/{buoi_nhom}/edit', [BuoiNhomController::class, 'edit'])
        ->middleware('checkPermission:manage-buoi-nhom')
        ->name('edit');
    Route::get('/filter', [BuoiNhomController::class, 'filter'])
        ->middleware('checkPermission:view-buoi-nhom')
        ->name('filter');
});

Route::prefix('api/buoi-nhom')->middleware(['auth'])->name('api.buoi_nhom.')->group(function () {
    Route::get('/', [BuoiNhomController::class, 'getBuoiNhoms'])
        ->middleware('checkPermission:view-buoi-nhom')
        ->name('list');
    Route::get('/{buoi_nhom}', [BuoiNhomController::class, 'getBuoiNhomJson'])
        ->middleware('checkPermission:view-buoi-nhom')
        ->name('details');
    Route::post('/', [BuoiNhomController::class, 'store'])
        ->middleware('checkPermission:manage-buoi-nhom')
        ->name('store');
    Route::put('/{buoi_nhom}', [BuoiNhomController::class, 'update'])
        ->middleware('checkPermission:manage-buoi-nhom')
        ->name('update');
    Route::delete('/{buoi_nhom}', [BuoiNhomController::class, 'destroy'])
        ->middleware('checkPermission:manage-buoi-nhom')
        ->name('destroy');
    Route::put('/{buoi_nhom}/update-counts', [BuoiNhomController::class, 'updateCounts'])
        ->middleware('checkPermission:manage-buoi-nhom')
        ->name('update_counts');
});

Route::get('/api/tin-huu/by-ban-nganh/{ban_nganh_id}', [BuoiNhomController::class, 'getTinHuuByBanNganh'])
    ->middleware(['auth', 'checkPermission:view-tin-huu'])
    ->name('api.tin_huu.by_ban_nganh');



// ==== Báo Cáo ====
Route::prefix('bao-cao')->middleware(['auth'])->group(function () {
    Route::get('/thiet-bi', [BaoCaoController::class, 'thietBi'])
        ->middleware('checkPermission:view-bao-cao-thiet-bi')
        ->name('_bao_cao.thiet_bi');
    Route::get('/tai-chinh', [BaoCaoController::class, 'taiChinh'])
        ->middleware('checkPermission:view-bao-cao-tai-chinh')
        ->name('_bao_cao.tai_chinh');
    Route::get('/hoi-thanh', [BaoCaoController::class, 'hoiThanh'])
        ->middleware('checkPermission:view-bao-cao-hoi-thanh')
        ->name('_bao_cao.hoi_thanh');
});

// ==== Quản lý Ban Ngành ====
require __DIR__ . '/than_huu.php';
require __DIR__ . '/dien_gia.php';
require __DIR__ . '/quan_ly/thong_bao.php';
require __DIR__ . '/tai_chinh/tai_chinh.php';
require __DIR__ . '/quan_ly/thiet_bi.php';
require __DIR__ . '/ban_nganh/ban_nganh.php';
require __DIR__ . '/ban_nganh/ban_trung_lao.php';
require __DIR__ . '/ban_nganh/ban_co_doc_giao_duc.php';
require __DIR__ . '/ban_nganh/ban_thanh_trang.php';
