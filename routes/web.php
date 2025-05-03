<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController,
    TinHuuController,
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
    BanNganhController,
    TinHuuBanNganhController,
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
Route::prefix('quan-ly-tin-huu')->middleware($quanTriTruongBan)->group(function () {
    Route::resource('tin-huu', TinHuuController::class)->names('_tin_huu');
    Route::get('/api/tin-huu', [TinHuuController::class, 'getTinHuus'])->name('api.tin_huu.list');
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

        Route::resource('ban-thieu-nhi-au', BanThieuNhiAuController::class)->names('_ban_thieu_nhi_au');
    });
});

// ==== Quản lý Diễn Giả ====
// --- Diễn Giả Routes ---
// ===== Các Route trả về VIEW (dùng cho tải trang lần đầu) =====
Route::prefix('dien-gia')->name('_dien_gia.')->group(function () {
    // GET /dien-gia -> Hiển thị trang danh sách diễn giả
    Route::get('/', [DienGiaController::class, 'index'])->name('index');

    // GET /dien-gia/create -> Hiển thị form tạo mới diễn giả
    Route::get('/create', [DienGiaController::class, 'create'])->name('create');

    // GET /dien-gia/{dienGia}/edit -> Hiển thị form sửa diễn giả
    Route::get('/{dienGia}/edit', [DienGiaController::class, 'edit'])->name('edit');

    // GET /dien-gia/{dienGia} -> Xem chi tiết diễn giả
    Route::get('/{dienGia}', [DienGiaController::class, 'show'])->name('show');
});

// ===== Các Route API trả về JSON (dùng cho các request AJAX) =====
Route::prefix('api/dien-gia')->name('api.dien_gia.')->group(function () {
    // GET /api/dien-gia -> Lấy danh sách diễn giả (JSON)
    Route::get('/', [DienGiaController::class, 'getDienGias'])->name('list');

    // GET /api/dien-gia/{dienGia} -> Lấy thông tin chi tiết 1 diễn giả (JSON)
    Route::get('/{dienGia}', [DienGiaController::class, 'getDienGiaJson'])->name('details');

    // POST /api/dien-gia -> Lưu diễn giả mới
    Route::post('/', [DienGiaController::class, 'store'])->name('store');

    // PUT /api/dien-gia/{dienGia} -> Cập nhật diễn giả
    Route::put('/{dienGia}', [DienGiaController::class, 'update'])->name('update');

    // DELETE /api/dien-gia/{dienGia} -> Xóa diễn giả
    Route::delete('/{dienGia}', [DienGiaController::class, 'destroy'])->name('destroy');
});



// ==== Quản lý / Thân Hữu / Thiết Bị ====
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
    Route::get('bao-cao-ban-co-doc-giao-duc', [BaoCaoController::class, 'baoCaoBanCoDocGiaoDuc'])->name('_bao_cao.ban_co_doc_giao_duc');
});


Route::get('/tin-huu-ban-nganh', [TinHuuBanNganhController::class, 'index'])->name('_tin_huu_ban_nganh.index');
Route::post('/tin-huu-ban-nganh', [TinHuuBanNganhController::class, 'store'])->name('_tin_huu_ban_nganh.store');
Route::get('/tin-huu-ban-nganh/members', [TinHuuBanNganhController::class, 'getMembers'])->name('_tin_huu_ban_nganh.members');
Route::delete('/tin-huu-ban-nganh', [TinHuuBanNganhController::class, 'destroy'])->name('_tin_huu_ban_nganh.destroy');
Route::get('/tin-huu-ban-nganh/edit', [TinHuuBanNganhController::class, 'edit'])->name('_tin_huu_ban_nganh.edit');
Route::put('/tin-huu-ban-nganh/update', [TinHuuBanNganhController::class, 'update'])->name('_tin_huu_ban_nganh.update');





// ==== Cài Đặt ====
Route::get('cai-dat/cai-dat-he-thong', [CaiDatController::class, 'index'])->middleware($quanTri)->name('_cai_dat.he_thong');


// --- Buổi Nhóm Routes ---
// ===== Các Route trả về VIEW (dùng cho tải trang lần đầu) =====
Route::prefix('buoi-nhom')->name('buoi_nhom.')->group(function () {
    // GET /buoi-nhom -> Hiển thị trang danh sách buổi nhóm
    Route::get('/', [BuoiNhomController::class, 'index'])->name('index');

    // GET /buoi-nhom/create -> Hiển thị form tạo mới buổi nhóm
    Route::get('/create', [BuoiNhomController::class, 'create'])->name('create');

    // GET /buoi-nhom/{buoi_nhom}/edit -> Hiển thị form sửa buổi nhóm
    Route::get('/{buoi_nhom}/edit', [BuoiNhomController::class, 'edit'])->name('edit');

    // Add a new route for filtering
    Route::get('/filter', [BuoiNhomController::class, 'filter'])
        ->name('filter');

    // Route::get('/{buoi_nhom}', [BuoiNhomController::class, 'show'])->name('show'); // Nếu có trang show
});


// ===== Các Route API trả về JSON (dùng cho các request AJAX) =====

// API liên quan đến Buổi Nhóm
Route::prefix('api/buoi-nhom')->name('api.buoi_nhom.')->group(function () {
    // GET /api/buoi-nhom -> Lấy danh sách buổi nhóm (JSON) cho bảng
    Route::get('/', [BuoiNhomController::class, 'getBuoiNhoms'])->name('list'); // <--- Tên khớp với JS: api.buoi_nhom.list

    // GET /api/buoi-nhom/{buoi_nhom} -> Lấy thông tin chi tiết 1 buổi nhóm (JSON) cho form edit
    Route::get('/{buoi_nhom}', [BuoiNhomController::class, 'getBuoiNhomJson'])->name('details'); // <--- Tên khớp với JS: api.buoi_nhom.details (Nếu JS dùng tên này)

    // POST /api/buoi-nhom -> Lưu buổi nhóm mới (trả về JSON)
    Route::post('/', [BuoiNhomController::class, 'store'])->name('store'); // <--- Tên khớp với JS: api.buoi_nhom.store

    // PUT/PATCH /api/buoi-nhom/{buoi_nhom} -> Cập nhật buổi nhóm (trả về JSON)
    Route::put('/{buoi_nhom}', [BuoiNhomController::class, 'update'])->name('update'); // <--- Tên khớp với JS: api.buoi_nhom.update
    // Route::patch('/{buoi_nhom}', [BuoiNhomController::class, 'update']);

    // DELETE /api/buoi-nhom/{buoi_nhom} -> Xóa buổi nhóm (trả về JSON)
    Route::delete('/{buoi_nhom}', [BuoiNhomController::class, 'destroy'])->name('destroy'); // <--- Tên khớp với JS: api.buoi_nhom.destroy

    // PUT /api/buoi-nhom/{buoi_nhom}/update-counts -> Cập nhật số lượng (trả về JSON)
    Route::put('/{buoi_nhom}/update-counts', [BuoiNhomController::class, 'updateCounts'])->name('update_counts');
});

// API lấy Tín hữu theo Ban ngành
Route::get('/api/tin-huu/by-ban-nganh/{ban_nganh_id}', [BuoiNhomController::class, 'getTinHuuByBanNganh'])
    ->name('api.tin_huu.by_ban_nganh'); // <--- Tên khớp với JS: api.tin_huu.by_ban_nganh




use App\Http\Controllers\BanMucVu\BanMucVuThamViengController;
use App\Http\Controllers\BanMucVu\BanMucVuBaoCaoController;

// Route web cho Ban Mục Vụ
Route::prefix('ban-muc-vu')->name('ban_muc_vu.')->group(function () {
    // Trang chính (quản lý thành viên)
    Route::get('{ban_nganh_id}/index', [BanMucVuController::class, 'index'])->name('index');

    // Điểm danh
    Route::get('{ban_nganh_id}/diem-danh', [BanMucVuController::class, 'diemDanh'])->name('diem_danh');

    // Thăm viếng
    Route::get('{ban_nganh_id}/tham-vieng', [BanMucVuController::class, 'thamVieng'])->name('tham_vieng');

    // Phân công
    Route::get('{ban_nganh_id}/phan-cong', [BanMucVuController::class, 'phanCong'])->name('phan_cong');

    // Phân công chi tiết
    Route::get('{ban_nganh_id}/phan-cong-chi-tiet', [BanMucVuController::class, 'phanCongChiTiet'])->name('phan_cong_chi_tiet');

    // Nhập liệu báo cáo
    Route::get('{ban_nganh_id}/nhap-lieu-bao-cao', [BanMucVuController::class, 'formBaoCaoBanMucVu'])->name('nhap_lieu_bao_cao');

    // Xem báo cáo
    Route::get('{ban_nganh_id}/bao-cao', [BanMucVuController::class, 'baoCaoBanMucVu'])->name('bao_cao');
});

// Route API cho Ban Mục Vụ
Route::prefix('api/ban-muc-vu')->name('api.ban_muc_vu.')->group(function () {
    // Quản lý thành viên
    Route::post('them-thanh-vien', [BanMucVuThanhVienController::class, 'themThanhVien'])->name('them_thanh_vien');
    Route::post('cap-nhat-chuc-vu', [BanMucVuThanhVienController::class, 'capNhatChucVu'])->name('cap_nhat_chuc_vu');
    Route::post('xoa-thanh-vien', [BanMucVuThanhVienController::class, 'xoaThanhVien'])->name('xoa_thanh_vien');
    Route::get('{ban_nganh_id}/dieu-hanh-list', [BanMucVuThanhVienController::class, 'dieuHanhList'])->name('dieu_hanh_list');
    Route::get('{ban_nganh_id}/ban-vien-list', [BanMucVuThanhVienController::class, 'banVienList'])->name('ban_vien_list');

    // Điểm danh
    Route::post('luu-diem-danh', [BanMucVuThanhVienController::class, 'luuDiemDanh'])->name('luu_diem_danh');
    Route::post('them-buoi-nhom', [BanMucVuThanhVienController::class, 'themBuoiNhom'])->name('them_buoi_nhom');

    // Thăm viếng
    Route::post('them-tham-vieng/{ban_nganh_id}', [BanMucVuThamViengController::class, 'themThamVieng'])->name('them_tham_vieng');
    Route::get('filter-de-xuat-tham-vieng', [BanMucVuThamViengController::class, 'filterDeXuatThamVieng'])->name('filter_de_xuat_tham_vieng');
    Route::get('filter-tham-vieng', [BanMucVuThamViengController::class, 'filterThamVieng'])->name('filter_tham_vieng');
    Route::get('chi-tiet-tham-vieng/{id}', [BanMucVuThamViengController::class, 'chiTietThamVieng'])->name('chi_tiet_tham_vieng');

    // Phân công
    Route::post('phan-cong-nhiem-vu', [BanMucVuThanhVienController::class, 'phanCongNhiemVu'])->name('phan_cong_nhiem_vu');
    Route::delete('xoa-phan-cong/{id}', [BanMucVuThanhVienController::class, 'xoaPhanCong'])->name('xoa_phan_cong');
    Route::post('update-buoi-nhom/{buoiNhom}', [BanMucVuThanhVienController::class, 'updateBuoiNhom'])->name('update_buoi_nhom');
    Route::delete('delete-buoi-nhom/{buoiNhom}', [BanMucVuThanhVienController::class, 'deleteBuoiNhom'])->name('delete_buoi_nhom');

    // Nhập liệu báo cáo
    Route::post('update-tham-du', [BanMucVuBaoCaoController::class, 'updateThamDuBanMucVu'])->name('update_tham_du');
    Route::post('save-tham-du', [BanMucVuBaoCaoController::class, 'saveThamDuBanMucVu'])->name('save_tham_du');
    Route::post('save-danh-gia', [BanMucVuBaoCaoController::class, 'saveDanhGiaBanMucVu'])->name('save_danh_gia');
    Route::post('save-ke-hoach', [BanMucVuBaoCaoController::class, 'saveKeHoachBanMucVu'])->name('save_ke_hoach');
    Route::post('save-kien-nghi', [BanMucVuBaoCaoController::class, 'saveKienNghiBanMucVu'])->name('save_kien_nghi');
    Route::delete('xoa-danh-gia/{id}', [BanMucVuBaoCaoController::class, 'xoaDanhGia'])->name('xoa_danh_gia');
    Route::delete('xoa-kien-nghi/{id}', [BanMucVuBaoCaoController::class, 'xoaKienNghi'])->name('xoa_kien_nghi');
});







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


// Include router của từng ban ngành
require __DIR__ . '/ban_nganh/ban_trung_lao.php';
require __DIR__ . '/ban_nganh/ban_thanh_trang.php';
require __DIR__ . '/quan_ly/thiet_bi.php';
require __DIR__ . '/quan_ly/thong_bao.php';