<?php

use App\Http\Controllers\BanThanhTrangController;
use Illuminate\Support\Facades\Route;

// API routes cho Ban Thanh Tráng
Route::prefix('api/ban-thanh-trang')
    ->middleware(['auth'])
    ->name('api.ban_thanh_trang.')
    ->group(function () {
        // Quản lý thành viên
        Route::post('/them-thanh-vien', [BanThanhTrangController::class, 'themThanhVien'])
            ->middleware('Permission:manage-thanh-vien-ban-nganh-thanh-trang')
            ->name('them_thanh_vien');
        Route::delete('/xoa-thanh-vien', [BanThanhTrangController::class, 'xoaThanhVien'])
            ->middleware('Permission:manage-thanh-vien-ban-nganh-thanh-trang')
            ->name('xoa_thanh_vien');
        Route::put('/cap-nhat-chuc-vu', [BanThanhTrangController::class, 'capNhatChucVu'])
            ->middleware('Permission:manage-thanh-vien-ban-nganh-thanh-trang')
            ->name('cap_nhat_chuc_vu');

        // Danh sách thành viên
        Route::get('/dieu-hanh-list', [BanThanhTrangController::class, 'dieuHanhList'])
            ->middleware('Permission:view-thanh-vien-ban-nganh-thanh-trang')
            ->name('dieu_hanh_list');
        Route::get('/ban-vien-list', [BanThanhTrangController::class, 'banVienList'])
            ->middleware('Permission:view-thanh-vien-ban-nganh-thanh-trang')
            ->name('ban_vien_list');

        // Quản lý buổi nhóm
        Route::get('/buoi-nhom', [BanThanhTrangController::class, 'getBuoiNhomList'])
            ->middleware('Permission:manage-buoi-nhom-ban-nganh-thanh-trang')
            ->name('buoi_nhom_list');
        Route::post('/buoi-nhom', [BanThanhTrangController::class, 'themBuoiNhom'])
            ->middleware('Permission:manage-buoi-nhom-ban-nganh-thanh-trang')
            ->name('them_buoi_nhom');
        Route::put('/buoi-nhom/{buoiNhom}', [BanThanhTrangController::class, 'updateBuoiNhom'])
            ->middleware('Permission:manage-buoi-nhom-ban-nganh-thanh-trang')
            ->name('update_buoi_nhom');
        Route::delete('/buoi-nhom/{buoiNhom}', [BanThanhTrangController::class, 'deleteBuoiNhom'])
            ->middleware('Permission:manage-buoi-nhom-ban-nganh-thanh-trang')
            ->name('delete_buoi_nhom');
        Route::post('/luu-diem-danh', [BanThanhTrangController::class, 'luuDiemDanh'])
            ->middleware('Permission:manage-buoi-nhom-ban-nganh-thanh-trang')
            ->name('luu_diem_danh');

        // Quản lý thăm viếng
        Route::post('/them-tham-vieng', [BanThanhTrangController::class, 'themThamVieng'])
            ->middleware('Permission:manage-tham-vieng-ban-nganh-thanh-trang')
            ->name('them_tham_vieng');
        Route::put('/tham-vieng/{id}', [BanThanhTrangController::class, 'updateThamVieng'])
            ->middleware('Permission:manage-tham-vieng-ban-nganh-thanh-trang')
            ->name('update_tham_vieng');
        Route::get('/chi-tiet-tham-vieng/{id}', [BanThanhTrangController::class, 'chiTietThamVieng'])
            ->middleware('Permission:manage-tham-vieng-ban-nganh-thanh-trang')
            ->name('chi_tiet_tham_vieng');
        Route::get('/filter-de-xuat-tham-vieng', [BanThanhTrangController::class, 'filterDeXuatThamVieng'])
            ->middleware('Permission:manage-tham-vieng-ban-nganh-thanh-trang')
            ->name('filter_de_xuat_tham_vieng');
        Route::get('/filter-tham-vieng', [BanThanhTrangController::class, 'filterThamVieng'])
            ->middleware('Permission:manage-tham-vieng-ban-nganh-thanh-trang')
            ->name('filter_tham_vieng');

        // Quản lý phân công
        Route::post('/phan-cong-nhiem-vu', [BanThanhTrangController::class, 'phanCongNhiemVu'])
            ->middleware('Permission:manage-phan-cong-ban-nganh-thanh-trang')
            ->name('phan_cong_nhiem_vu');
        Route::delete('/xoa-phan-cong/{id}', [BanThanhTrangController::class, 'xoaPhanCong'])
            ->middleware('Permission:manage-phan-cong-ban-nganh-thanh-trang')
            ->name('xoa_phan_cong');

        // Báo cáo và thống kê
        Route::post('/luu-bao-cao', [BanThanhTrangController::class, 'luuBaoCaoBanTrungLao'])
            ->middleware('Permission:manage-bao-cao-ban-nganh-thanh-trang')
            ->name('luu_bao_cao');
        Route::post('/update-thamdu-trung-lao', [BanThanhTrangController::class, 'updateThamDuTrungLao'])
            ->middleware('Permission:manage-bao-cao-ban-nganh-thanh-trang')
            ->name('update_thamdu_trung_lao');
        Route::delete('/xoa-danh-gia/{id}', [BanThanhTrangController::class, 'xoaDanhGia'])
            ->middleware('Permission:manage-bao-cao-ban-nganh-thanh-trang')
            ->name('xoa_danh_gia');
        Route::delete('/xoa-kien-nghi/{id}', [BanThanhTrangController::class, 'xoaKienNghi'])
            ->middleware('Permission:manage-bao-cao-ban-nganh-thanh-trang')
            ->name('xoa_kien_nghi');
    });

// Web routes cho Ban Thanh Tráng (giao diện quản lý)
Route::middleware(['auth'])
    ->prefix('ban-thanh-trang')
    ->name('_ban_thanh_trang.')
    ->group(function () {
        Route::get('/', [BanThanhTrangController::class, 'index'])
            ->middleware('Permission:view-ban-nganh-thanh-trang')
            ->name('index');
        Route::get('diem-danh', [BanThanhTrangController::class, 'diemDanh'])
            ->middleware('Permission:diem-danh-ban-nganh-thanh-trang')
            ->name('diem_danh');
        Route::get('tham-vieng', [BanThanhTrangController::class, 'thamVieng'])
            ->middleware('Permission:tham-vieng-ban-nganh-thanh-trang')
            ->name('tham_vieng');
        Route::get('phan-cong', [BanThanhTrangController::class, 'phanCong'])
            ->middleware('Permission:phan-cong-ban-nganh-thanh-trang')
            ->name('phan_cong');
        Route::get('phan-cong-chi-tiet', [BanThanhTrangController::class, 'phanCongChiTiet'])
            ->middleware('Permission:phan-cong-chi-tiet-ban-nganh-thanh-trang')
            ->name('phan_cong_chi_tiet');
        Route::get('nhap-lieu-bao-cao', [BanThanhTrangController::class, 'formBaoCaoBanTrungLao'])
            ->middleware('Permission:nhap-lieu-bao-cao-ban-nganh-thanh-trang')
            ->name('nhap_lieu_bao_cao');
        Route::get('bao-cao-ban-thanh-trang', [BanThanhTrangController::class, 'baoCaoBanTrungLao'])
            ->middleware('Permission:bao-cao-ban-nganh-thanh-trang')
            ->name('bao_cao_ban_thanh_trang');

        // Routes cho các chức năng lưu dữ liệu
        Route::post('save-thamdu-trung-lao', [BanThanhTrangController::class, 'saveThamDuTrungLao'])
            ->middleware('Permission:manage-bao-cao-ban-nganh-thanh-trang')
            ->name('save_thamdu_trung_lao');
        Route::post('save-danhgia-trung-lao', [BanThanhTrangController::class, 'saveDanhGiaTrungLao'])
            ->middleware('Permission:manage-bao-cao-ban-nganh-thanh-trang')
            ->name('save_danhgia_trung_lao');
        Route::post('save-kehoach-trung-lao', [BanThanhTrangController::class, 'saveKeHoachTrungLao'])
            ->middleware('Permission:manage-bao-cao-ban-nganh-thanh-trang')
            ->name('save_kehoach_trung_lao');
        Route::post('save-kiennghi-trung-lao', [BanThanhTrangController::class, 'saveKienNghiTrungLao'])
            ->middleware('Permission:manage-bao-cao-ban-nganh-thanh-trang')
            ->name('save_kiennghi_trung_lao');

        // API cập nhật nhanh từng dòng
        Route::post('update-thamdu-trung-lao', [BanThanhTrangController::class, 'updateThamDuTrungLao'])
            ->middleware('Permission:manage-bao-cao-ban-nganh-thanh-trang')
            ->name('update_thamdu_trung_lao');
    });

// Web routes cho Báo Cáo
Route::prefix('bao-cao')
    ->middleware(['auth'])
    ->name('_bao_cao.')
    ->group(function () {
        Route::get('ban-thanh-trang', [App\Http\Controllers\BanThanhTrang\BaoCaoBanThanhTrangController::class, 'baoCaoBanTrungLao'])
            ->middleware('Permission:bao-cao-ban-nganh-thanh-trang')
            ->name('ban_thanh_trang');
    });
