<?php

use App\Http\Controllers\BanCoDocGiaoDuc\BanCDGDController;
use Illuminate\Support\Facades\Route;

// Định nghĩa controller để sử dụng ngắn gọn
$controller = BanCDGDController::class;

// Nhóm route cho ban ngành với prefix {banType} (ví dụ: ban-co-doc-giao-duc)
Route::prefix('{banType}')->name('_ban_')->group(function () use ($controller) {
    // Trang chính (URL: /{banType})
    Route::get('/', [$controller, 'index'])->name('co_doc_giao_duc.index')->middleware('auth');
    // Trang điểm danh (URL: /{banType}/diem-danh)
    Route::get('/diem-danh', [$controller, 'diemDanh'])->name('co_doc_giao_duc.diem_danh')->middleware('auth');
    // Trang phân công (URL: /{banType}/phan-cong)
    Route::get('/phan-cong', [$controller, 'phanCong'])->name('co_doc_giao_duc.phan_cong')->middleware('auth');
    // Trang phân công chi tiết (URL: /{banType}/phan-cong-chi-tiet)
    Route::get('/phan-cong-chi-tiet', [$controller, 'phanCongChiTiet'])->name('co_doc_giao_duc.phan_cong_chi_tiet')->middleware('auth');
    // Trang báo cáo (URL: /{banType}/bao-cao)
    Route::get('/bao-cao', [$controller, 'baoCaoBan'])->name('co_doc_giao_duc.bao_cao')->middleware('auth');
    // Trang nhập liệu báo cáo (URL: /{banType}/nhap-lieu-bao-cao)
    Route::get('/nhap-lieu-bao-cao', [$controller, 'formBaoCaoBan'])->name('co_doc_giao_duc.nhap_lieu_bao_cao')->middleware('auth');
});

// Nhóm route API cho ban ngành (URL: api/{banType}/*)
Route::prefix('api/{banType}')->name('api._ban_')->middleware(['auth'])->group(function () use ($controller) {
    Route::post('/them-thanh-vien', [$controller, 'themThanhVien'])->name('co_doc_giao_duc.them_thanh_vien');
    Route::post('/xoa-thanh-vien', [$controller, 'xoaThanhVien'])->name('co_doc_giao_duc.xoa_thanh_vien');
    Route::post('/cap-nhat-chuc-vu', [$controller, 'capNhatChucVu'])->name('co_doc_giao_duc.cap_nhat_chuc_vu');
    Route::get('/chi-tiet-thanh-vien', [$controller, 'chiTietThanhVien'])->name('co_doc_giao_duc.chi_tiet_thanh_vien');
    Route::post('/luu-diem-danh', [$controller, 'luuDiemDanh'])->name('co_doc_giao_duc.luu_diem_danh');
    Route::post('/them-buoi-nhom', [$controller, 'themBuoiNhom'])->name('co_doc_giao_duc.them_buoi_nhom');
    Route::get('/dieu-hanh-list', [$controller, 'dieuHanhList'])->name('co_doc_giao_duc.dieu_hanh_list');
    Route::get('/ban-vien-list', [$controller, 'banVienList'])->name('co_doc_giao_duc.ban_vien_list');
    Route::put('/buoi-nhom/{buoiNhom}', [$controller, 'updateBuoiNhom'])->name('co_doc_giao_duc.update_buoi_nhom');
    Route::delete('/buoi-nhom/{buoiNhom}', [$controller, 'deleteBuoiNhom'])->name('co_doc_giao_duc.delete_buoi_nhom');
    Route::post('/phan-cong-nhiem-vu', [$controller, 'phanCongNhiemVu'])->name('co_doc_giao_duc.phan_cong_nhiem_vu');
    Route::delete('/xoa-phan-cong/{id}', [$controller, 'xoaPhanCong'])->name('co_doc_giao_duc.xoa_phan_cong');
    Route::post('/update-tham-du', [$controller, 'updateThamDu'])->name('co_doc_giao_duc.update_tham_du');
    Route::post('/save-tham-du', [$controller, 'saveThamDu'])->name('co_doc_giao_duc.save_tham_du');
    Route::post('/save-danh-gia', [$controller, 'saveDanhGia'])->name('co_doc_giao_duc.save_danh_gia');
    Route::post('/save-ke-hoach', [$controller, 'saveKeHoach'])->name('co_doc_giao_duc.save_ke_hoach');
    Route::post('/save-kien-nghi', [$controller, 'saveKienNghi'])->name('co_doc_giao_duc.save_kien_nghi');
    Route::post('/luu-bao-cao', [$controller, 'luuBaoCao'])->name('co_doc_giao_duc.luu_bao_cao');
    Route::delete('/xoa-danh-gia/{id}', [$controller, 'xoaDanhGia'])->name('co_doc_giao_duc.xoa_danh_gia');
    Route::delete('/xoa-kien-nghi/{id}', [$controller, 'xoaKienNghi'])->name('co_doc_giao_duc.xoa_kien_nghi');
    Route::get('/danh-gia-list', [$controller, 'danhGiaList'])->name('co_doc_giao_duc.danh_gia_list');
});
