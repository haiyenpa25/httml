<?php

use App\Http\Controllers\BanTrungLaoController;
use Illuminate\Support\Facades\Route;



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
        Route::get('/buoi-nhom', [BanTrungLaoController::class, 'getBuoiNhomList'])->name('buoi_nhom_list');
        Route::post('/buoi-nhom', [BanTrungLaoController::class, 'themBuoiNhom'])->name('them_buoi_nhom');
        Route::put('/buoi-nhom/{buoiNhom}', [BanTrungLaoController::class, 'updateBuoiNhom'])->name('update_buoi_nhom');
        Route::delete('/buoi-nhom/{buoiNhom}', [BanTrungLaoController::class, 'deleteBuoiNhom'])->name('delete_buoi_nhom');
        Route::post('/luu-diem-danh', [BanTrungLaoController::class, 'luuDiemDanh'])->name('luu_diem_danh');

        // Quản lý thăm viếng
        Route::post('/them-tham-vieng', [BanTrungLaoController::class, 'themThamVieng'])->name('them_tham_vieng');
        Route::put('/tham-vieng/{id}', [BanTrungLaoController::class, 'updateThamVieng'])->name('update_tham_vieng');
        Route::get('/chi-tiet-tham-vieng/{id}', [BanTrungLaoController::class, 'chiTietThamVieng'])->name('chi_tiet_tham_vieng');
        Route::get('/filter-de-xuat-tham-vieng', [BanTrungLaoController::class, 'filterDeXuatThamVieng'])->name('filter_de_xuat_tham_vieng');
        Route::get('/filter-tham-vieng', [BanTrungLaoController::class, 'filterThamVieng'])->name('filter_tham_vieng');

        // Quản lý phân công
        Route::post('/phan-cong-nhiem-vu', [BanTrungLaoController::class, 'phanCongNhiemVu'])->name('phan_cong_nhiem_vu');
        Route::delete('/xoa-phan-cong/{id}', [BanTrungLaoController::class, 'xoaPhanCong'])->name('xoa_phan_cong');

        // Báo cáo và thống kê
        Route::post('/luu-bao-cao', [BanTrungLaoController::class, 'luuBaoCaoBanTrungLao'])->name('luu_bao_cao');
        Route::post('/update-thamdu-trung-lao', [BanTrungLaoController::class, 'updateThamDuTrungLao'])->name('update_thamdu_trung_lao');
        Route::delete('/xoa-danh-gia/{id}', [BanTrungLaoController::class, 'xoaDanhGia'])->name('xoa_danh_gia');
        Route::delete('/xoa-kien-nghi/{id}', [BanTrungLaoController::class, 'xoaKienNghi'])->name('xoa_kien_nghi');
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
        Route::get('nhap-lieu-bao-cao', [BanTrungLaoController::class, 'formBaoCaoBanTrungLao'])->name('nhap_lieu_bao_cao');
        Route::get('bao-cao-ban-trung-lao', [BanTrungLaoController::class, 'baoCaoBanTrungLao'])->name('bao_cao_ban_trung_lao');

        // Routes cho các chức năng lưu dữ liệu
        Route::post('save-thamdu-trung-lao', [BanTrungLaoController::class, 'saveThamDuTrungLao'])->name('save_thamdu_trung_lao');
        Route::post('save-danhgia-trung-lao', [BanTrungLaoController::class, 'saveDanhGiaTrungLao'])->name('save_danhgia_trung_lao');
        Route::post('save-kehoach-trung-lao', [BanTrungLaoController::class, 'saveKeHoachTrungLao'])->name('save_kehoach_trung_lao');
        Route::post('save-kiennghi-trung-lao', [BanTrungLaoController::class, 'saveKienNghiTrungLao'])->name('save_kiennghi_trung_lao');

        // API cập nhật nhanh từng dòng
        Route::post('update-thamdu-trung-lao', [BanTrungLaoController::class, 'updateThamDuTrungLao'])->name('update_thamdu_trung_lao');
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
        Route::get('ban-trung-lao', [App\Http\Controllers\BanTrungLao\BaoCaoBanTrungLaoController::class, 'baoCaoBanTrungLao'])
            ->name('ban_trung_lao');
    });
