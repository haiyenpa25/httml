<?php

use App\Http\Controllers\BanCoDocGiaoDuc\BanCDGDController;
use Illuminate\Support\Facades\Route;

// Định nghĩa controller để sử dụng ngắn gọn
$controller = BanCDGDController::class;

// Nhóm route cho ban ngành với prefix {banType} (ví dụ: ban-co-doc-giao-duc)
Route::prefix('{banType}')->name('_ban_')->group(function () use ($controller) {
    // Trang chính (URL: /{banType})
    Route::get('/', [$controller, 'index'])->name('{banType}.index');
    // Trang điểm danh (URL: /{banType}/diem-danh)
    Route::get('/diem-danh', [$controller, 'diemDanh'])->name('{banType}.diem_danh');
    // Trang phân công (URL: /{banType}/phan-cong)
    Route::get('/phan-cong', [$controller, 'phanCong'])->name('{banType}.phan_cong');
    // Trang phân công chi tiết (URL: /{banType}/phan-cong-chi-tiet)
    Route::get('/phan-cong-chi-tiet', [$controller, 'phanCongChiTiet'])->name('{banType}.phan_cong_chi_tiet');
    // Trang báo cáo (URL: /{banType}/bao-cao)
    Route::get('/bao-cao', [$controller, 'baoCaoBan'])->name('{banType}.bao_cao');
    // Trang nhập liệu báo cáo (URL: /{banType}/nhap-lieu-bao-cao)
    Route::get('/nhap-lieu-bao-cao', [$controller, 'formBaoCaoBan'])->name('{banType}.nhap_lieu_bao_cao');
});

// Nhóm route API cho ban ngành (URL: api/{banType}/*)
Route::prefix('api/{banType}')->name('api._ban_')->group(function () use ($controller) {
    Route::post('/them-thanh-vien', [$controller, 'themThanhVien'])->name('{banType}.them_thanh_vien');
    Route::post('/xoa-thanh-vien', [$controller, 'xoaThanhVien'])->name('{banType}.xoa_thanh_vien');
    Route::post('/cap-nhat-chuc-vu', [$controller, 'capNhatChucVu'])->name('{banType}.cap_nhat_chuc_vu');
    Route::get('/chi-tiet-thanh-vien', [$controller, 'chiTietThanhVien'])->name('{banType}.chi_tiet_thanh_vien');
    Route::post('/luu-diem-danh', [$controller, 'luuDiemDanh'])->name('{banType}.luu_diem_danh');
    Route::post('/them-buoi-nhom', [$controller, 'themBuoiNhom'])->name('{banType}.them_buoi_nhom');
    Route::get('/dieu-hanh-list', [$controller, 'dieuHanhList'])->name('{banType}.dieu_hanh_list');
    Route::get('/ban-vien-list', [$controller, 'banVienList'])->name('{banType}.ban_vien_list');
    Route::put('/buoi-nhom/{buoiNhom}', [$controller, 'updateBuoiNhom'])->name('{banType}.update_buoi_nhom');
    Route::delete('/buoi-nhom/{buoiNhom}', [$controller, 'deleteBuoiNhom'])->name('{banType}.delete_buoi_nhom');
    Route::post('/phan-cong-nhiem-vu', [$controller, 'phanCongNhiemVu'])->name('{banType}.phan_cong_nhiem_vu');
    Route::delete('/xoa-phan-cong/{id}', [$controller, 'xoaPhanCong'])->name('{banType}.xoa_phan_cong');
    Route::post('/update-tham-du', [$controller, 'updateThamDu'])->name('{banType}.update_tham_du');
    Route::post('/save-tham-du', [$controller, 'saveThamDu'])->name('{banType}.save_tham_du');
    Route::post('/save-danh-gia', [$controller, 'saveDanhGia'])->name('{banType}.save_danh_gia');
    Route::post('/save-ke-hoach', [$controller, 'saveKeHoach'])->name('{banType}.save_ke_hoach');
    Route::post('/save-kien-nghi', [$controller, 'saveKienNghi'])->name('{banType}.save_kien_nghi');
    Route::post('/luu-bao-cao', [$controller, 'luuBaoCao'])->name('{banType}.luu_bao_cao');
    Route::post('/cap-nhat-so-luong-tham-du', [$controller, 'capNhatSoLuongThamDu'])->name('{banType}.cap_nhat_so_luong_tham_du');
    Route::delete('/xoa-danh-gia/{id}', [$controller, 'xoaDanhGia'])->name('{banType}.xoa_danh_gia');
    Route::delete('/xoa-kien-nghi/{id}', [$controller, 'xoaKienNghi'])->name('{banType}.xoa_kien_nghi');
});
