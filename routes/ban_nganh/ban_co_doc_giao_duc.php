<?php

use App\Http\Controllers\BanCoDocGiaoDuc\BanCDGDController;
use Illuminate\Support\Facades\Route;

$controller = BanCDGDController::class;

Route::prefix('{banType}')->name('_ban_')->group(function () use ($controller) {
    // Trang chính
    Route::get('/', [$controller, 'index'])->name('co_doc_giao_duc.index')->middleware(['auth', 'checkPermission:view-ban-co-doc-giao-duc']);
    // Trang điểm danh
    Route::get('/diem-danh', [$controller, 'diemDanh'])->name('co_doc_giao_duc.diem_danh')->middleware(['auth', 'checkPermission:diem-danh-ban-co-doc-giao-duc']);
    // Trang phân công
    Route::get('/phan-cong', [$controller, 'phanCong'])->name('co_doc_giao_duc.phan_cong')->middleware(['auth', 'checkPermission:phan-cong-ban-co-doc-giao-duc']);
    // Trang phân công chi tiết
    Route::get('/phan-cong-chi-tiet', [$controller, 'phanCongChiTiet'])->name('co_doc_giao_duc.phan_cong_chi_tiet')->middleware(['auth', 'checkPermission:phan-cong-chi-tiet-ban-co-doc-giao-duc']);
    // Trang báo cáo
    Route::get('/bao-cao', [$controller, 'baoCaoBan'])->name('co_doc_giao_duc.bao_cao')->middleware(['auth', 'checkPermission:bao-cao-ban-co-doc-giao-duc']);
    // Trang nhập liệu báo cáo
    Route::get('/nhap-lieu-bao-cao', [$controller, 'formBaoCaoBan'])->name('co_doc_giao_duc.nhap_lieu_bao_cao')->middleware(['auth', 'checkPermission:nhap-lieu-bao-cao-ban-co-doc-giao-duc']);
});

Route::prefix('api/{banType}')->name('api._ban_')->middleware(['auth'])->group(function () use ($controller) {
    // Thành viên
    Route::post('/them-thanh-vien', [$controller, 'themThanhVien'])->name('co_doc_giao_duc.them_thanh_vien')->middleware('checkPermission:manage-thanh-vien-ban-co-doc-giao-duc');
    Route::post('/xoa-thanh-vien', [$controller, 'xoaThanhVien'])->name('co_doc_giao_duc.xoa_thanh_vien')->middleware('checkPermission:manage-thanh-vien-ban-co-doc-giao-duc');
    Route::post('/cap-nhat-chuc-vu', [$controller, 'capNhatChucVu'])->name('co_doc_giao_duc.cap_nhat_chuc_vu')->middleware('checkPermission:manage-thanh-vien-ban-co-doc-giao-duc');
    Route::get('/chi-tiet-thanh-vien', [$controller, 'chiTietThanhVien'])->name('co_doc_giao_duc.chi_tiet_thanh_vien')->middleware('checkPermission:manage-thanh-vien-ban-co-doc-giao-duc');
    Route::get('/dieu-hanh-list', [$controller, 'dieuHanhList'])->name('co_doc_giao_duc.dieu_hanh_list')->middleware('checkPermission:view-thanh-vien-ban-co-doc-giao-duc');
    Route::get('/ban-vien-list', [$controller, 'banVienList'])->name('co_doc_giao_duc.ban_vien_list')->middleware('checkPermission:view-thanh-vien-ban-co-doc-giao-duc');

    // Điểm danh
    Route::post('/luu-diem-danh', [$controller, 'luuDiemDanh'])->name('co_doc_giao_duc.luu_diem_danh')->middleware('checkPermission:manage-diem-danh-ban-co-doc-giao-duc');
    Route::post('/update-tham-du', [$controller, 'updateThamDu'])->name('co_doc_giao_duc.update_tham_du')->middleware('checkPermission:manage-diem-danh-ban-co-doc-giao-duc');
    Route::post('/save-tham-du', [$controller, 'saveThamDu'])->name('co_doc_giao_duc.save_tham_du')->middleware('checkPermission:manage-diem-danh-ban-co-doc-giao-duc');

    // Buổi nhóm
    Route::post('/them-buoi-nhom', [$controller, 'themBuoiNhom'])->name('co_doc_giao_duc.them_buoi_nhom')->middleware('checkPermission:manage-buoi-nhom-ban-co-doc-giao-duc');
    Route::put('/buoi-nhom/{buoiNhom}', [$controller, 'updateBuoiNhom'])->name('co_doc_giao_duc.update_buoi_nhom')->middleware('checkPermission:manage-buoi-nhom-ban-co-doc-giao-duc');
    Route::delete('/buoi-nhom/{buoiNhom}', [$controller, 'deleteBuoiNhom'])->name('co_doc_giao_duc.delete_buoi_nhom')->middleware('checkPermission:manage-buoi-nhom-ban-co-doc-giao-duc');

    // Phân công
    Route::post('/phan-cong-nhiem-vu', [$controller, 'phanCongNhiemVu'])->name('co_doc_giao_duc.phan_cong_nhiem_vu')->middleware('checkPermission:manage-phan-cong-ban-co-doc-giao-duc');
    Route::delete('/xoa-phan-cong/{id}', [$controller, 'xoaPhanCong'])->name('co_doc_giao_duc.xoa_phan_cong')->middleware('checkPermission:manage-phan-cong-ban-co-doc-giao-duc');

    // Báo cáo
    Route::post('/save-danh-gia', [$controller, 'saveDanhGia'])->name('co_doc_giao_duc.save_danh_gia')->middleware('checkPermission:manage-bao-cao-ban-co-doc-giao-duc');
    Route::post('/save-ke-hoach', [$controller, 'saveKeHoach'])->name('co_doc_giao_duc.save_ke_hoach')->middleware('checkPermission:manage-bao-cao-ban-co-doc-giao-duc');
    Route::post('/save-kien-nghi', [$controller, 'saveKienNghi'])->name('co_doc_giao_duc.save_kien_nghi')->middleware('checkPermission:manage-bao-cao-ban-co-doc-giao-duc');
    Route::post('/luu-bao-cao', [$controller, 'luuBaoCao'])->name('co_doc_giao_duc.luu_bao_cao')->middleware('checkPermission:manage-bao-cao-ban-co-doc-giao-duc');
    Route::delete('/xoa-danh-gia/{id}', [$controller, 'xoaDanhGia'])->name('co_doc_giao_duc.xoa_danh_gia')->middleware('checkPermission:manage-bao-cao-ban-co-doc-giao-duc');
    Route::delete('/xoa-kien-nghi/{id}', [$controller, 'xoaKienNghi'])->name('co_doc_giao_duc.xoa_kien_nghi')->middleware('checkPermission:manage-bao-cao-ban-co-doc-giao-duc');
    Route::get('/danh-gia-list', [$controller, 'danhGiaList'])->name('co_doc_giao_duc.danh_gia_list')->middleware('checkPermission:manage-bao-cao-ban-co-doc-giao-duc');
});
