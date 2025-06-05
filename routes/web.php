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
    TrangChuController,
    QuanTri\RoleController,
    QuanTri\PermissionController
};

// ==== Auth Routes ====
Route::get('/', fn() => redirect()->route('login'));
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/trang-chu', [TrangChuController::class, 'index'])->name('trang-chu');
Route::get('/trang-chu2', [TrangChuController::class, 'index'])->name('dashboard');

// API cho Trang Chủ
Route::prefix('api/trang-chu')->middleware(['auth'])->name('api.trang_chu.')->group(function () {
    Route::get('/birthday-list', [TrangChuController::class, 'getBirthdayList'])
        ->middleware('permission:view-dashboard')
        ->name('birthday_list');
    Route::get('/event-list', [TrangChuController::class, 'getEventList'])
        ->middleware('permission:view-dashboard')
        ->name('event_list');
});

// Quản lý vai trò và quyền
Route::middleware(['auth', 'verified', 'permission:manage-roles'])->prefix('quan-tri')->group(function () {
    Route::resource('roles', RoleController::class);
});

Route::middleware(['auth', 'verified', 'permission:manage-permissions'])->prefix('quan-tri')->group(function () {
    Route::resource('permissions', PermissionController::class);
});

// Tìm kiếm tín hữu
Route::get('tin-huu/search', [App\Http\Controllers\TinHuuController::class, 'search'])
    ->middleware(['auth', 'verified'])
    ->name('tin-huu.search');

// Quản lý lớp học
Route::prefix('lop-hoc')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [App\Http\Controllers\LopHocController::class, 'index'])
        ->middleware('permission:view-lop-hoc')
        ->name('lop-hoc.index');
    Route::get('/create', [App\Http\Controllers\LopHocController::class, 'create'])
        ->middleware('permission:create-lop-hoc')
        ->name('lop-hoc.create');
    Route::post('/', [App\Http\Controllers\LopHocController::class, 'store'])
        ->middleware('permission:create-lop-hoc')
        ->name('lop-hoc.store');
    Route::get('/{lopHoc}', [App\Http\Controllers\LopHocController::class, 'show'])
        ->middleware('permission:view-lop-hoc')
        ->name('lop-hoc.show');
    Route::get('/{lopHoc}/edit', [App\Http\Controllers\LopHocController::class, 'edit'])
        ->middleware('permission:edit-lop-hoc')
        ->name('lop-hoc.edit');
    Route::put('/{lopHoc}', [App\Http\Controllers\LopHocController::class, 'update'])
        ->middleware('permission:edit-lop-hoc')
        ->name('lop-hoc.update');
    Route::delete('/{lopHoc}', [App\Http\Controllers\LopHocController::class, 'destroy'])
        ->middleware('permission:delete-lop-hoc')
        ->name('lop-hoc.destroy');
});

Route::post('lop-hoc/{lopHoc}/hoc-vien', [App\Http\Controllers\LopHocController::class, 'themHocVien'])
    ->middleware(['auth', 'verified', 'permission:manage-hoc-vien'])
    ->name('lop-hoc.them-hoc-vien');

Route::delete('lop-hoc/{lopHoc}/hoc-vien/{tinHuu}', [App\Http\Controllers\LopHocController::class, 'xoaHocVien'])
    ->middleware(['auth', 'verified', 'permission:manage-hoc-vien'])
    ->name('lop-hoc.xoa-hoc-vien');

// Quản lý phân quyền người dùng
Route::prefix('quan-ly-phan-quyen')->middleware(['auth'])->group(function () {
    Route::get('/', [NguoiDungPhanQuyenController::class, 'index'])
        ->middleware('permission:manage-phan-quyen')
        ->name('_phan_quyen.index');
    Route::get('/user/{userId}', [NguoiDungPhanQuyenController::class, 'showUserPermissions'])
        ->middleware('permission:manage-phan-quyen')
        ->name('_phan_quyen.user');
    Route::get('/role-permissions', [NguoiDungPhanQuyenController::class, 'getRolePermissions'])
        ->middleware('permission:manage-phan-quyen')
        ->name('_phan_quyen.role_permissions');
    Route::post('/update-role/{userId}', [NguoiDungPhanQuyenController::class, 'updateRole'])
        ->middleware('permission:manage-phan-quyen')
        ->name('_phan_quyen.update_role');
    Route::get('/user-permissions/{userId}', [NguoiDungPhanQuyenController::class, 'getUserPermissions'])
        ->middleware('permission:manage-phan-quyen')
        ->name('_phan_quyen.get_user_permissions');
    Route::post('/update-permissions/{userId}', [NguoiDungPhanQuyenController::class, 'updateUserPermissions'])
        ->middleware('permission:manage-phan-quyen')
        ->name('_phan_quyen.update_permissions');
    Route::get('/user-default-urls/{userId}', [NguoiDungPhanQuyenController::class, 'getUserDefaultUrls'])
        ->middleware('permission:manage-phan-quyen')
        ->name('_phan_quyen.get_user_default_urls');
    Route::post('/update-default-url/{userId}', [NguoiDungPhanQuyenController::class, 'updateDefaultUrl'])
        ->middleware('permission:manage-phan-quyen')
        ->name('_phan_quyen.update_default_url');
});

// Quản lý tín hữu
require __DIR__ . '/quan_ly/tin_huu.php';

// Quản lý người dùng & hộ gia đình
Route::prefix('nguoi-dung')->middleware(['auth'])->group(function () {
    Route::get('/', [NguoiDungController::class, 'index'])
        ->middleware('permission:view-nguoi-dung')
        ->name('nguoi_dung.index');
    Route::get('/create', [NguoiDungController::class, 'create'])
        ->middleware('permission:create-nguoi-dung')
        ->name('nguoi_dung.create');
    Route::post('/', [NguoiDungController::class, 'store'])
        ->middleware('permission:create-nguoi-dung')
        ->name('nguoi_dung.store');
    Route::get('/{nguoiDung}', [NguoiDungController::class, 'show'])
        ->middleware('permission:view-nguoi-dung')
        ->name('nguoi_dung.show');
    Route::get('/{nguoiDung}/edit', [NguoiDungController::class, 'edit'])
        ->middleware('permission:update-nguoi-dung')
        ->name('nguoi_dung.edit');
    Route::put('/{nguoiDung}', [NguoiDungController::class, 'update'])
        ->middleware('permission:update-nguoi-dung')
        ->name('nguoi_dung.update');
    Route::delete('/{nguoiDung}', [NguoiDungController::class, 'destroy'])
        ->middleware('permission:delete-nguoi-dung')
        ->name('nguoi_dung.destroy');
});

Route::prefix('ho-gia-dinh')->middleware(['auth'])->group(function () {
    Route::get('/', [HoGiaDinhController::class, 'index'])
        ->middleware('permission:view-ho-gia-dinh')
        ->name('_ho_gia_dinh.index');
    Route::get('/create', [HoGiaDinhController::class, 'create'])
        ->middleware('permission:create-ho-gia-dinh')
        ->name('_ho_gia_dinh.create');
    Route::post('/', [HoGiaDinhController::class, 'store'])
        ->middleware('permission:create-ho-gia-dinh')
        ->name('_ho_gia_dinh.store');
    Route::get('/{hoGiaDinh}', [HoGiaDinhController::class, 'show'])
        ->middleware('permission:view-ho-gia-dinh')
        ->name('_ho_gia_dinh.show');
    Route::get('/{hoGiaDinh}/edit', [HoGiaDinhController::class, 'edit'])
        ->middleware('permission:update-ho-gia-dinh')
        ->name('_ho_gia_dinh.edit');
    Route::put('/{hoGiaDinh}', [HoGiaDinhController::class, 'update'])
        ->middleware('permission:update-ho-gia-dinh')
        ->name('_ho_gia_dinh.update');
    Route::delete('/{hoGiaDinh}', [HoGiaDinhController::class, 'destroy'])
        ->middleware('permission:delete-ho-gia-dinh')
        ->name('_ho_gia_dinh.destroy');
});

// Quản lý thân hữu / thiết bị
Route::prefix('quan-ly-than-huu')->middleware(['auth'])->group(function () {
    Route::get('/', [ThanHuuController::class, 'index'])
        ->middleware('permission:view-than-huu')
        ->name('_than_huu.index');
    Route::get('/create', [ThanHuuController::class, 'create'])
        ->middleware('permission:manage-than-huu')
        ->name('_than_huu.create');
    Route::post('/', [ThanHuuController::class, 'store'])
        ->middleware('permission:manage-than-huu')
        ->name('_than_huu.store');
    Route::get('/{thanHuu}', [ThanHuuController::class, 'show'])
        ->middleware('permission:view-than-huu')
        ->name('_than_huu.show');
    Route::get('/{thanHuu}/edit', [ThanHuuController::class, 'edit'])
        ->middleware('permission:manage-than-huu')
        ->name('_than_huu.edit');
    Route::put('/{thanHuu}', [ThanHuuController::class, 'update'])
        ->middleware('permission:manage-than-huu')
        ->name('_than_huu.update');
    Route::delete('/{thanHuu}', [ThanHuuController::class, 'destroy'])
        ->middleware('permission:manage-than-huu')
        ->name('_than_huu.destroy');
});

Route::prefix('quan-ly-thiet-bi')->middleware(['auth'])->group(function () {
    Route::get('/', [ThietBiController::class, 'index'])
        ->middleware('permission:view-thiet-bi')
        ->name('_thiet_bi.index');
    Route::get('/create', [ThietBiController::class, 'create'])
        ->middleware('permission:manage-thiet-bi')
        ->name('_thiet_bi.create');
    Route::post('/', [ThietBiController::class, 'store'])
        ->middleware('permission:manage-thiet-bi')
        ->name('_thiet_bi.store');
    Route::get('/{thietBi}', [ThietBiController::class, 'show'])
        ->middleware('permission:view-thiet-bi')
        ->name('_thiet_bi.show');
    Route::get('/{thietBi}/edit', [ThietBiController::class, 'edit'])
        ->middleware('permission:manage-thiet-bi')
        ->name('_thiet_bi.edit');
    Route::put('/{thietBi}', [ThietBiController::class, 'update'])
        ->middleware('permission:manage-thiet-bi')
        ->name('_thiet_bi.update');
    Route::delete('/{thietBi}', [ThietBiController::class, 'destroy'])
        ->middleware('permission:manage-thiet-bi')
        ->name('_thiet_bi.destroy');
    Route::get('bao-cao-thiet-bi', [ThietBiController::class, 'baoCao'])
        ->middleware('permission:view-thiet-bi-bao-cao')
        ->name('_thiet_bi.bao_cao');
    Route::get('thanh-ly-thiet-bi', [ThietBiController::class, 'thanhLy'])
        ->middleware('permission:manage-thiet-bi')
        ->name('_thiet_bi.thanh_ly');
});

// Quản lý tài chính
Route::prefix('quan-ly-tai-chinh')->middleware(['auth'])->group(function () {
    Route::get('bao-cao-tai-chinh', [TaiChinhController::class, 'baoCao'])
        ->middleware('permission:view-bao-cao-tai-chinh')
        ->name('_tai_chinh.bao_cao');
    Route::get('thu-chi', [TaiChinhController::class, 'index'])
        ->middleware('permission:view-tai-chinh')
        ->name('_thu_chi.index');
    Route::get('thu-chi/create', [TaiChinhController::class, 'create'])
        ->middleware('permission:manage-tai-chinh')
        ->name('_thu_chi.create');
    Route::post('thu-chi', [TaiChinhController::class, 'store'])
        ->middleware('permission:manage-tai-chinh')
        ->name('_thu_chi.store');
    Route::get('thu-chi/{thuChi}', [TaiChinhController::class, 'show'])
        ->middleware('permission:view-tai-chinh')
        ->name('_thu_chi.show');
    Route::get('thu-chi/{thuChi}/edit', [TaiChinhController::class, 'edit'])
        ->middleware('permission:manage-tai-chinh')
        ->name('_thu_chi.edit');
    Route::put('thu-chi/{thuChi}', [TaiChinhController::class, 'update'])
        ->middleware('permission:manage-tai-chinh')
        ->name('_thu_chi.update');
    Route::delete('thu-chi/{thuChi}', [TaiChinhController::class, 'destroy'])
        ->middleware('permission:manage-tai-chinh')
        ->name('_thu_chi.destroy');
});

// Quản lý thờ phượng
Route::prefix('quan-ly-tho-phuong')->middleware(['auth'])->group(function () {
    Route::get('danh-sach-buoi-nhom', [ThoPhuongController::class, 'danhSachBuoiNhom'])
        ->middleware('permission:view-tho-phuong')
        ->name('_tho_phuong.buoi_nhom');
    Route::get('danh-sach-ngay-le', [ThoPhuongController::class, 'danhSachNgayLe'])
        ->middleware('permission:view-tho-phuong')
        ->name('_tho_phuong.ngay_le');
    Route::get('them-buoi-nhom', [ThoPhuongController::class, 'create'])
        ->middleware('permission:manage-tho-phuong')
        ->name('_tho_phuong.create');
});

// Quản lý tài liệu
Route::prefix('quan-ly-tai-lieu')->middleware(['auth'])->group(function () {
    Route::get('/', [TaiLieuController::class, 'index'])
        ->middleware('permission:view-tai-lieu')
        ->name('_tai_lieu.index');
    Route::get('/create', [TaiLieuController::class, 'create'])
        ->middleware('permission:manage-tai-lieu')
        ->name('_tai_lieu.create');
    Route::post('/', [TaiLieuController::class, 'store'])
        ->middleware('permission:manage-tai-lieu')
        ->name('_tai_lieu.store');
    Route::get('/{taiLieu}', [TaiLieuController::class, 'show'])
        ->middleware('permission:view-tai-lieu')
        ->name('_tai_lieu.show');
    Route::get('/{taiLieu}/edit', [TaiLieuController::class, 'edit'])
        ->middleware('permission:manage-tai-lieu')
        ->name('_tai_lieu.edit');
    Route::put('/{taiLieu}', [TaiLieuController::class, 'update'])
        ->middleware('permission:manage-tai-lieu')
        ->name('_tai_lieu.update');
    Route::delete('/{taiLieu}', [TaiLieuController::class, 'destroy'])
        ->middleware('permission:manage-tai-lieu')
        ->name('_tai_lieu.destroy');
});

// Thông báo
Route::get('quan-ly-thong-bao/thong-bao', [ThongBaoController::class, 'index'])
    ->middleware(['auth', 'permission:view-thong-bao'])
    ->name('_thong_bao.index');

// Cài đặt
Route::get('cai-dat/cai-dat-he-thong', [CaiDatController::class, 'index'])
    ->middleware(['auth', 'permission:view-cai-dat'])
    ->name('_cai_dat.he_thong');

// Buổi nhóm
Route::prefix('buoi-nhom')->middleware(['auth'])->name('buoi_nhom.')->group(function () {
    Route::get('/', [BuoiNhomController::class, 'index'])
        ->middleware('permission:view-buoi-nhom')
        ->name('index');
    Route::get('/create', [BuoiNhomController::class, 'create'])
        ->middleware('permission:manage-buoi-nhom')
        ->name('create');
    Route::get('/{buoi_nhom}/edit', [BuoiNhomController::class, 'edit'])
        ->middleware('permission:manage-buoi-nhom')
        ->name('edit');
    Route::get('/filter', [BuoiNhomController::class, 'filter'])
        ->middleware('permission:view-buoi-nhom')
        ->name('filter');
});

Route::prefix('api/buoi-nhom')->middleware(['auth'])->name('api.buoi_nhom.')->group(function () {
    Route::get('/', [BuoiNhomController::class, 'getBuoiNhoms'])
        ->middleware('permission:view-buoi-nhom')
        ->name('list');
    Route::get('/{buoi_nhom}', [BuoiNhomController::class, 'getBuoiNhomJson'])
        ->middleware('permission:view-buoi-nhom')
        ->name('details');
    Route::post('/', [BuoiNhomController::class, 'store'])
        ->middleware('permission:manage-buoi-nhom')
        ->name('store');
    Route::put('/{buoi_nhom}', [BuoiNhomController::class, 'update'])
        ->middleware('permission:manage-buoi-nhom')
        ->name('update');
    Route::delete('/{buoi_nhom}', [BuoiNhomController::class, 'destroy'])
        ->middleware('permission:manage-buoi-nhom')
        ->name('destroy');
    Route::put('/{buoi_nhom}/update-counts', [BuoiNhomController::class, 'updateCounts'])
        ->middleware('permission:manage-buoi-nhom')
        ->name('update_counts');
});

Route::get('/api/tin-huu/by-ban-nganh/{ban_nganh_id}', [BuoiNhomController::class, 'getTinHuuByBanNganh'])
    ->middleware(['auth', 'permission:view-tin-huu'])
    ->name('api.tin_huu.by_ban_nganh');

// Báo cáo
Route::prefix('bao-cao')->middleware(['auth'])->group(function () {
    Route::get('/thiet-bi', [BaoCaoController::class, 'thietBi'])
        ->middleware('permission:view-bao-cao-thiet-bi')
        ->name('_bao_cao.thiet_bi');
    Route::get('/tai-chinh', [BaoCaoController::class, 'taiChinh'])
        ->middleware('permission:view-bao-cao-tai-chinh')
        ->name('_bao_cao.tai_chinh');
    Route::get('/hoi-thanh', [BaoCaoController::class, 'hoiThanh'])
        ->middleware('permission:view-bao-cao-hoi-thanh')
        ->name('_bao_cao.hoi_thanh');
});

// Import các file route khác
require __DIR__ . '/than_huu.php';
require __DIR__ . '/dien_gia.php';
require __DIR__ . '/quan_ly/thong_bao.php';
require __DIR__ . '/tai_chinh/tai_chinh.php';
require __DIR__ . '/quan_ly/thiet_bi.php';
require __DIR__ . '/ban_nganh/ban_nganh.php';
// require __DIR__ . '/ban_nganh/ban_trung_lao.php';
require __DIR__ . '/ban_nganh/ban_co_doc_giao_duc.php';
// require __DIR__ . '/ban_nganh/ban_thanh_trang.php';
require __DIR__ . '/lop_hoc.php';
