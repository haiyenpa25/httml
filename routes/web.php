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
    ChiTietThamGiaController
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
        Route::resource('ban-thanh-trang', BanThanhTrangController::class)->names('_ban_thanh_trang');
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


// routes/web.php

/*
|--------------------------------------------------------------------------
| API routes cho Ban Trung Lão
|--------------------------------------------------------------------------
*/
Route::prefix('api/ban-trung-lao')
    ->name('api.ban_trung_lao.')
    ->group(function () {
        // Quản lý thành viên
        Route::post('/them-thanh-vien', [BanTrungLaoController::class, 'themThanhVien'])->name('them_thanh_vien');
        Route::delete('/xoa-thanh-vien', [BanTrungLaoController::class, 'xoaThanhVien'])->name('xoa_thanh_vien');
        Route::put('/cap-nhat-chuc-vu', [BanTrungLaoController::class, 'capNhatChucVu'])->name('cap_nhat_chuc_vu');

        // Danh sách thành viên
        Route::get('/dieu-hanh-list', [BanTrungLaoController::class, 'dieuHanhList'])->name('dieu_hanh_list');
        Route::get('/ban-vien-list', [BanTrungLaoController::class, 'banVienList'])->name('ban_vien_list');

        // Quản lý buổi nhóm
        Route::post('/buoi-nhom', [BanTrungLaoController::class, 'themBuoiNhom'])->name('them_buoi_nhom');
        Route::put('/buoi-nhom/{buoiNhom}', [BanTrungLaoController::class, 'updateBuoiNhom'])->name('update_buoi_nhom');
        Route::delete('/buoi-nhom/{buoiNhom}', [BanTrungLaoController::class, 'deleteBuoiNhom'])->name('delete_buoi_nhom');
        Route::post('/luu-diem-danh', [BanTrungLaoController::class, 'luuDiemDanh'])->name('luu_diem_danh');

        // Quản lý thăm viếng
        Route::post('/them-tham-vieng', [BanTrungLaoController::class, 'themThamVieng'])->name('them_tham_vieng');
        Route::get('/chi-tiet-tham-vieng/{id}', [BanTrungLaoController::class, 'chiTietThamVieng'])->name('chi_tiet_tham_vieng');
        Route::get('/filter-de-xuat-tham-vieng', [BanTrungLaoController::class, 'filterDeXuatThamVieng'])->name('filter_de_xuat_tham_vieng');
        Route::get('/filter-tham-vieng', [BanTrungLaoController::class, 'filterThamVieng'])->name('filter_tham_vieng');

        // Quản lý phân công
        Route::post('/phan-cong-nhiem-vu', [BanTrungLaoController::class, 'phanCongNhiemVu'])->name('phan_cong_nhiem_vu');
        Route::delete('/xoa-phan-cong/{id}', [BanTrungLaoController::class, 'xoaPhanCong'])->name('xoa_phan_cong');

        // Báo cáo và thống kê (thêm mới)
        Route::post('/luu-bao-cao', [BanTrungLaoController::class, 'luuBaoCaoBanTrungLao'])->name('luu_bao_cao');
        Route::post('/cap-nhat-so-luong-tham-du', [BanTrungLaoController::class, 'capNhatSoLuongThamDu'])->name('cap_nhat_so_luong_tham_du');
        Route::post('/luu-danh-gia', [BanTrungLaoController::class, 'luuDanhGia'])->name('luu_danh_gia');
        Route::post('/luu-ke-hoach', [BanTrungLaoController::class, 'luuKeHoach'])->name('luu_ke_hoach');
        Route::post('/luu-kien-nghi', [BanTrungLaoController::class, 'luuKienNghi'])->name('luu_kien_nghi');
    });


/*
|--------------------------------------------------------------------------
| Web routes cho Ban Trung Lão (giao diện quản lý)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'checkRole:quan_tri,truong_ban'])
    ->prefix('ban-trung-lao')
    ->name('_ban_trung_lao.')
    ->group(function () {
        Route::get('/', [BanTrungLaoController::class, 'index'])->name('index');
        Route::get('diem-danh', [BanTrungLaoController::class, 'diemDanh'])->name('diem_danh');
        Route::get('tham-vieng', [BanTrungLaoController::class, 'thamVieng'])->name('tham_vieng');
        Route::get('phan-cong', [BanTrungLaoController::class, 'phanCong'])->name('phan_cong');
        Route::get('phan-cong-chi-tiet', [BanTrungLaoController::class, 'phanCongChiTiet'])->name('phan_cong_chi_tiet');

        // Form nhập liệu báo cáo Ban Trung Lão
        Route::get('nhap-lieu-bao-cao', [BanTrungLaoController::class, 'formBaoCaoBanTrungLao'])
            ->name('nhap_lieu_bao_cao');

        // Routes cho các chức năng lưu dữ liệu
        Route::post('save-thamdu-trung-lao', [BanTrungLaoController::class, 'saveThamDuTrungLao'])
            ->name('save_thamdu_trung_lao');
        Route::post('save-danhgia-trung-lao', [BanTrungLaoController::class, 'saveDanhGiaTrungLao'])
            ->name('save_danhgia_trung_lao');
        Route::post('save-kehoach-trung-lao', [BanTrungLaoController::class, 'saveKeHoachTrungLao'])
            ->name('save_kehoach_trung_lao');
        Route::post('save-kiennghi-trung-lao', [BanTrungLaoController::class, 'saveKienNghiTrungLao'])
            ->name('save_kiennghi_trung_lao');

        // API cập nhật nhanh từng dòng
        // Thay đổi thành capNhatSoLuongThamDu
        Route::post('update-thamdu-trung-lao', [BanTrungLaoController::class, 'updateThamDuTrungLao'])
            ->name('update_thamdu_trung_lao');
    });


/*
|--------------------------------------------------------------------------
| Web routes cho Báo Cáo Ban Trung Lão
|--------------------------------------------------------------------------
*/
Route::prefix('bao-cao')
    ->middleware(['auth']) // Thêm middleware nếu cần
    ->name('_bao_cao.')
    ->group(function () {


    });












// Routes cho Thiết Bị
Route::middleware(['auth'])->group(function () {
    Route::get('/thiet-bi', [App\Http\Controllers\ThietBiController::class, 'index'])->name('thiet-bi.index');
    Route::get('/thiet-bi/get-thiet-bis', [App\Http\Controllers\ThietBiController::class, 'getThietBis'])->name('thiet-bi.get-thiet-bis');
    Route::post('/thiet-bi', [App\Http\Controllers\ThietBiController::class, 'store'])->name('thiet-bi.store');
    Route::get('/thiet-bi/{thietBi}', [App\Http\Controllers\ThietBiController::class, 'show'])->name('thiet-bi.show');
    Route::get('/thiet-bi/{thietBi}/edit', [App\Http\Controllers\ThietBiController::class, 'edit'])->name('thiet-bi.edit');
    Route::post('/thiet-bi/{thietBi}', [App\Http\Controllers\ThietBiController::class, 'update'])->name('thiet-bi.update');
    Route::delete('/thiet-bi/{thietBi}', [App\Http\Controllers\ThietBiController::class, 'destroy'])->name('thiet-bi.destroy');

    Route::get('/thiet-bi-canh-bao', [App\Http\Controllers\ThietBiController::class, 'danhSachCanhBao'])->name('thiet-bi.canh-bao');
    Route::get('/thiet-bi-bao-cao', [App\Http\Controllers\ThietBiController::class, 'baoCao'])->name('thiet-bi.bao-cao');
    Route::get('/thiet-bi-export-excel', [App\Http\Controllers\ThietBiController::class, 'exportExcel'])->name('thiet-bi.export-excel');
    Route::get('/thiet-bi-export-pdf', [App\Http\Controllers\ThietBiController::class, 'exportPDF'])->name('thiet-bi.export-pdf');

    // Routes cho Nhà Cung Cấp
    Route::get('/nha-cung-cap', [App\Http\Controllers\NhaCungCapController::class, 'index'])->name('nha-cung-cap.index');
    Route::get('/nha-cung-cap/get-nha-cung-caps', [App\Http\Controllers\NhaCungCapController::class, 'getNhaCungCaps'])->name('nha-cung-cap.get-nha-cung-caps');
    Route::post('/nha-cung-cap', [App\Http\Controllers\NhaCungCapController::class, 'store'])->name('nha-cung-cap.store');
    Route::get('/nha-cung-cap/{nhaCungCap}', [App\Http\Controllers\NhaCungCapController::class, 'show'])->name('nha-cung-cap.show');
    Route::get('/nha-cung-cap/{nhaCungCap}/edit', [App\Http\Controllers\NhaCungCapController::class, 'edit'])->name('nha-cung-cap.edit');
    Route::put('/nha-cung-cap/{nhaCungCap}', [App\Http\Controllers\NhaCungCapController::class, 'update'])->name('nha-cung-cap.update');
    Route::delete('/nha-cung-cap/{nhaCungCap}', [App\Http\Controllers\NhaCungCapController::class, 'destroy'])->name('nha-cung-cap.destroy');

    // Routes cho Lịch Sử Bảo Trì
    Route::get('/lich-su-bao-tri/thiet-bi/{thietBiId}', [App\Http\Controllers\LichSuBaoTriController::class, 'getByThietBi'])->name('lich-su-bao-tri.get-by-thiet-bi');
    Route::post('/lich-su-bao-tri', [App\Http\Controllers\LichSuBaoTriController::class, 'store'])->name('lich-su-bao-tri.store');
    Route::get('/lich-su-bao-tri/{lichSuBaoTri}/edit', [App\Http\Controllers\LichSuBaoTriController::class, 'edit'])->name('lich-su-bao-tri.edit');
    Route::put('/lich-su-bao-tri/{lichSuBaoTri}', [App\Http\Controllers\LichSuBaoTriController::class, 'update'])->name('lich-su-bao-tri.update');
    Route::delete('/lich-su-bao-tri/{lichSuBaoTri}', [App\Http\Controllers\LichSuBaoTriController::class, 'destroy'])->name('lich-su-bao-tri.destroy');
});