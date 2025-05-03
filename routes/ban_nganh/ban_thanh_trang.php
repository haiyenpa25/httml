<?php

use App\Http\Controllers\BanThanhTrangController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API routes cho Ban Trung Lão
|--------------------------------------------------------------------------
*/
Route::prefix('api/ban-thanh-trang')
    ->name('api.ban_thanh_trang.')
    ->group(function () {
        // Quản lý thành viên
        Route::post('/them-thanh-vien', [BanThanhTrangController::class, 'themThanhVien'])->name('them_thanh_vien');
        Route::delete('/xoa-thanh-vien', [BanThanhTrangController::class, 'xoaThanhVien'])->name('xoa_thanh_vien');
        Route::put('/cap-nhat-chuc-vu', [BanThanhTrangController::class, 'capNhatChucVu'])->name('cap_nhat_chuc_vu');

        // Danh sách thành viên
        Route::get('/dieu-hanh-list', [BanThanhTrangController::class, 'dieuHanhList'])->name('dieu_hanh_list');
        Route::get('/ban-vien-list', [BanThanhTrangController::class, 'banVienList'])->name('ban_vien_list');

        // Quản lý buổi nhóm
        Route::get('/buoi-nhom', [BanThanhTrangController::class, 'getBuoiNhomList'])->name('buoi_nhom_list');
        Route::post('/buoi-nhom', [BanThanhTrangController::class, 'themBuoiNhom'])->name('them_buoi_nhom');
        Route::put('/buoi-nhom/{buoiNhom}', [BanThanhTrangController::class, 'updateBuoiNhom'])->name('update_buoi_nhom');
        Route::delete('/buoi-nhom/{buoiNhom}', [BanThanhTrangController::class, 'deleteBuoiNhom'])->name('delete_buoi_nhom');
        Route::post('/luu-diem-danh', [BanThanhTrangController::class, 'luuDiemDanh'])->name('luu_diem_danh');

        // Quản lý thăm viếng
        Route::post('/them-tham-vieng', [BanThanhTrangController::class, 'themThamVieng'])->name('them_tham_vieng');
        Route::put('/tham-vieng/{id}', [BanThanhTrangController::class, 'updateThamVieng'])->name('update_tham_vieng');
        Route::get('/chi-tiet-tham-vieng/{id}', [BanThanhTrangController::class, 'chiTietThamVieng'])->name('chi_tiet_tham_vieng');
        Route::get('/filter-de-xuat-tham-vieng', [BanThanhTrangController::class, 'filterDeXuatThamVieng'])->name('filter_de_xuat_tham_vieng');
        Route::get('/filter-tham-vieng', [BanThanhTrangController::class, 'filterThamVieng'])->name('filter_tham_vieng');

        // Quản lý phân công
        Route::post('/phan-cong-nhiem-vu', [BanThanhTrangController::class, 'phanCongNhiemVu'])->name('phan_cong_nhiem_vu');
        Route::delete('/xoa-phan-cong/{id}', [BanThanhTrangController::class, 'xoaPhanCong'])->name('xoa_phan_cong');

        // Báo cáo và thống kê
        Route::post('/luu-bao-cao', [BanThanhTrangController::class, 'luuBaoCaoBanTrungLao'])->name('luu_bao_cao');
        Route::post('/update-thamdu-trung-lao', [BanThanhTrangController::class, 'updateThamDuTrungLao'])->name('update_thamdu_trung_lao');
        Route::delete('/xoa-danh-gia/{id}', [BanThanhTrangController::class, 'xoaDanhGia'])->name('xoa_danh_gia');
        Route::delete('/xoa-kien-nghi/{id}', [BanThanhTrangController::class, 'xoaKienNghi'])->name('xoa_kien_nghi');
    });

/*
|--------------------------------------------------------------------------
| Web routes cho Ban Trung Lão (giao diện quản lý)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'checkRole:quan_tri,truong_ban'])
    ->prefix('ban-thanh-trang')
    ->name('_ban_thanh_trang.')
    ->group(function () {
        Route::get('/', [BanThanhTrangController::class, 'index'])->name('index');
        Route::get('diem-danh', [BanThanhTrangController::class, 'diemDanh'])->name('diem_danh');
        Route::get('tham-vieng', [BanThanhTrangController::class, 'thamVieng'])->name('tham_vieng');
        Route::get('phan-cong', [BanThanhTrangController::class, 'phanCong'])->name('phan_cong');
        Route::get('phan-cong-chi-tiet', [BanThanhTrangController::class, 'phanCongChiTiet'])->name('phan_cong_chi_tiet');
        Route::get('nhap-lieu-bao-cao', [BanThanhTrangController::class, 'formBaoCaoBanTrungLao'])->name('nhap_lieu_bao_cao');
        Route::get('bao-cao-ban-thanh-trang', [BanThanhTrangController::class, 'baoCaoBanTrungLao'])->name('bao_cao_ban_thanh_trang');

        // Routes cho các chức năng lưu dữ liệu
        Route::post('save-thamdu-trung-lao', [BanThanhTrangController::class, 'saveThamDuTrungLao'])->name('save_thamdu_trung_lao');
        Route::post('save-danhgia-trung-lao', [BanThanhTrangController::class, 'saveDanhGiaTrungLao'])->name('save_danhgia_trung_lao');
        Route::post('save-kehoach-trung-lao', [BanThanhTrangController::class, 'saveKeHoachTrungLao'])->name('save_kehoach_trung_lao');
        Route::post('save-kiennghi-trung-lao', [BanThanhTrangController::class, 'saveKienNghiTrungLao'])->name('save_kiennghi_trung_lao');

        // API cập nhật nhanh từng dòng
        Route::post('update-thamdu-trung-lao', [BanThanhTrangController::class, 'updateThamDuTrungLao'])->name('update_thamdu_trung_lao');
    });

/*
|--------------------------------------------------------------------------
| Web routes cho Báo Cáo
|--------------------------------------------------------------------------
*/
Route::prefix('bao-cao')
    ->middleware(['auth'])
    ->name('_bao_cao.')
    ->group(function () {
        Route::get('ban-thanh-trang', [App\Http\Controllers\BanThanhTrang\BaoCaoBanThanhTrangController::class, 'baoCaoBanTrungLao'])
            ->name('ban_thanh_trang');
    });
