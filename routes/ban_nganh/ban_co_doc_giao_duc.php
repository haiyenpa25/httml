<?php

use App\Http\Controllers\BanCoDocGiaoDucController;
use Illuminate\Support\Facades\Route;

// API routes cho Ban Cơ Đốc Giáo Dục
Route::prefix('api/ban-co-doc-giao-duc')
    ->middleware(['auth'])
    ->name('api.ban_co_doc_giao_duc.')
    ->group(function () {
        // Quản lý thành viên
        Route::post('/them-thanh-vien', [BanCoDocGiaoDucController::class, 'themThanhVien'])
            ->middleware('checkPermission:manage-thanh-vien-ban-co-doc-giao-duc')
            ->name('them_thanh_vien');
        Route::delete('/xoa-thanh-vien', [BanCoDocGiaoDucController::class, 'xoaThanhVien'])
            ->middleware('checkPermission:manage-thanh-vien-ban-co-doc-giao-duc')
            ->name('xoa_thanh_vien');
        Route::put('/cap-nhat-chuc-vu', [BanCoDocGiaoDucController::class, 'capNhatChucVu'])
            ->middleware('checkPermission:manage-thanh-vien-ban-co-doc-giao-duc')
            ->name('cap_nhat_chuc_vu');

        // Danh sách thành viên
        Route::get('/dieu-hanh-list', [BanCoDocGiaoDucController::class, 'dieuHanhList'])
            ->middleware('checkPermission:view-thanh-vien-ban-co-doc-giao-duc')
            ->name('dieu_hanh_list');
        Route::get('/ban-vien-list', [BanCoDocGiaoDucController::class, 'banVienList'])
            ->middleware('checkPermission:view-thanh-vien-ban-co-doc-giao-duc')
            ->name('ban_vien_list');

        // Quản lý buổi nhóm
        Route::get('/buoi-nhom', [BanCoDocGiaoDucController::class, 'getBuoiNhomList'])
            ->middleware('checkPermission:manage-buoi-nhom-ban-co-doc-giao-duc')
            ->name('buoi_nhom_list');
        Route::post('/buoi-nhom', [BanCoDocGiaoDucController::class, 'themBuoiNhom'])
            ->middleware('checkPermission:manage-buoi-nhom-ban-co-doc-giao-duc')
            ->name('them_buoi_nhom');
        Route::put('/buoi-nhom/{buoiNhom}', [BanCoDocGiaoDucController::class, 'updateBuoiNhom'])
            ->middleware('checkPermission:manage-buoi-nhom-ban-co-doc-giao-duc')
            ->name('update_buoi_nhom');
        Route::delete('/buoi-nhom/{buoiNhom}', [BanCoDocGiaoDucController::class, 'deleteBuoiNhom'])
            ->middleware('checkPermission:manage-buoi-nhom-ban-co-doc-giao-duc')
            ->name('delete_buoi_nhom');
        Route::post('/luu-diem-danh', [BanCoDocGiaoDucController::class, 'luuDiemDanh'])
            ->middleware('checkPermission:manage-buoi-nhom-ban-co-doc-giao-duc')
            ->name('luu_diem_danh');

        // Quản lý thăm viếng
        Route::post('/them-tham-vieng', [BanCoDocGiaoDucController::class, 'themThamVieng'])
            ->middleware('checkPermission:manage-tham-vieng-ban-co-doc-giao-duc')
            ->name('them_tham_vieng');
        Route::put('/tham-vieng/{id}', [BanCoDocGiaoDucController::class, 'updateThamVieng'])
            ->middleware('checkPermission:manage-tham-vieng-ban-co-doc-giao-duc')
            ->name('update_tham_vieng');
        Route::get('/chi-tiet-tham-vieng/{id}', [BanCoDocGiaoDucController::class, 'chiTietThamVieng'])
            ->middleware('checkPermission:manage-tham-vieng-ban-co-doc-giao-duc')
            ->name('chi_tiet_tham_vieng');
        Route::get('/filter-de-xuat-tham-vieng', [BanCoDocGiaoDucController::class, 'filterDeXuatThamVieng'])
            ->middleware('checkPermission:manage-tham-vieng-ban-co-doc-giao-duc')
            ->name('filter_de_xuat_tham_vieng');
        Route::get('/filter-tham-vieng', [BanCoDocGiaoDucController::class, 'filterThamVieng'])
            ->middleware('checkPermission:manage-tham-vieng-ban-co-doc-giao-duc')
            ->name('filter_tham_vieng');

        // Quản lý phân công
        Route::post('/phan-cong-nhiem-vu', [BanCoDocGiaoDucController::class, 'phanCongNhiemVu'])
            ->middleware('checkPermission:manage-phan-cong-ban-co-doc-giao-duc')
            ->name('phan_cong_nhiem_vu');
        Route::delete('/xoa-phan-cong/{id}', [BanCoDocGiaoDucController::class, 'xoaPhanCong'])
            ->middleware('checkPermission:manage-phan-cong-ban-co-doc-giao-duc')
            ->name('xoa_phan_cong');

        // Báo cáo và thống kê
        Route::post('/luu-bao-cao', [BanCoDocGiaoDucController::class, 'luuBaoCaoBanTrungLao'])
            ->middleware('checkPermission:manage-bao-cao-ban-co-doc-giao-duc')
            ->name('luu_bao_cao');
        Route::post('/update-thamdu-trung-lao', [BanCoDocGiaoDucController::class, 'updateThamDuTrungLao'])
            ->middleware('checkPermission:manage-bao-cao-ban-co-doc-giao-duc')
            ->name('update_thamdu_trung_lao');
        Route::delete('/xoa-danh-gia/{id}', [BanCoDocGiaoDucController::class, 'xoaDanhGia'])
            ->middleware('checkPermission:manage-bao-cao-ban-co-doc-giao-duc')
            ->name('xoa_danh_gia');
        Route::delete('/xoa-kien-nghi/{id}', [BanCoDocGiaoDucController::class, 'xoaKienNghi'])
            ->middleware('checkPermission:manage-bao-cao-ban-co-doc-giao-duc')
            ->name('xoa_kien_nghi');
    });

// Web routes cho Ban Cơ Đốc Giáo Dục (giao diện quản lý)
Route::middleware(['auth'])
    ->prefix('ban-co-doc-giao-duc')
    ->name('_ban_co_doc_giao_duc.')
    ->group(function () {
        Route::get('/', [BanCoDocGiaoDucController::class, 'index'])
            ->middleware('checkPermission:view-ban-co-doc-giao-duc')
            ->name('index');
        Route::get('diem-danh', [BanCoDocGiaoDucController::class, 'diemDanh'])
            ->middleware('checkPermission:diem-danh-ban-co-doc-giao-duc')
            ->name('diem_danh');
        Route::get('tham-vieng', [BanCoDocGiaoDucController::class, 'thamVieng'])
            ->middleware('checkPermission:tham-vieng-ban-co-doc-giao-duc')
            ->name('tham_vieng');
        Route::get('phan-cong', [BanCoDocGiaoDucController::class, 'phanCong'])
            ->middleware('checkPermission:phan-cong-ban-co-doc-giao-duc')
            ->name('phan_cong');
        Route::get('phan-cong-chi-tiet', [BanCoDocGiaoDucController::class, 'phanCongChiTiet'])
            ->middleware('checkPermission:phan-cong-chi-tiet-ban-co-doc-giao-duc')
            ->name('phan_cong_chi_tiet');
        Route::get('nhap-lieu-bao-cao', [BanCoDocGiaoDucController::class, 'formBaoCaoBanTrungLao'])
            ->middleware('checkPermission:nhap-lieu-bao-cao-ban-co-doc-giao-duc')
            ->name('nhap_lieu_bao_cao');
        Route::get('bao-cao-ban-co-doc-giao-duc', [BanCoDocGiaoDucController::class, 'baoCaoBanTrungLao'])
            ->middleware('checkPermission:bao-cao-ban-co-doc-giao-duc')
            ->name('bao_cao_ban_co_doc_giao_duc');

        // Routes cho các chức năng lưu dữ liệu
        Route::post('save-thamdu-trung-lao', [BanCoDocGiaoDucController::class, 'saveThamDuTrungLao'])
            ->middleware('checkPermission:manage-bao-cao-ban-co-doc-giao-duc')
            ->name('save_thamdu_trung_lao');
        Route::post('save-danhgia-trung-lao', [BanCoDocGiaoDucController::class, 'saveDanhGiaTrungLao'])
            ->middleware('checkPermission:manage-bao-cao-ban-co-doc-giao-duc')
            ->name('save_danhgia_trung_lao');
        Route::post('save-kehoach-trung-lao', [BanCoDocGiaoDucController::class, 'saveKeHoachTrungLao'])
            ->middleware('checkPermission:manage-bao-cao-ban-co-doc-giao-duc')
            ->name('save_kehoach_trung_lao');
        Route::post('save-kiennghi-trung-lao', [BanCoDocGiaoDucController::class, 'saveKienNghiTrungLao'])
            ->middleware('checkPermission:manage-bao-cao-ban-co-doc-giao-duc')
            ->name('save_kiennghi_trung_lao');

        // API cập nhật nhanh từng dòng
        Route::post('update-thamdu-trung-lao', [BanCoDocGiaoDucController::class, 'updateThamDuTrungLao'])
            ->middleware('checkPermission:manage-bao-cao-ban-co-doc-giao-duc')
            ->name('update_thamdu_trung_lao');
    });

// Web routes cho Báo Cáo
Route::prefix('bao-cao')
    ->middleware(['auth'])
    ->name('_bao_cao.')
    ->group(function () {
        // Route::get('ban-co-doc-giao-duc', [App\Http\Controllers\BanCoDocGiaoDuc\BaoCaoBanCoDocGiaoDucController::class, 'baoCaoBanTrungLao'])
        //     ->middleware('checkPermission:bao-cao-ban-co-doc-giao-duc')
        //     ->name('ban_co_doc_giao_duc');
    });
