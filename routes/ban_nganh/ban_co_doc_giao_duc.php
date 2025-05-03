<?php

use App\Http\Controllers\BanCoDocGiaoDucController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API routes cho Ban Trung Lão
|--------------------------------------------------------------------------
*/
Route::prefix('api/ban-co-doc-giao-duc')
    ->name('api.ban_thanh_trang.')
    ->group(function () {
        // Quản lý thành viên
        Route::post('/them-thanh-vien', [BanCoDocGiaoDucController::class, 'themThanhVien'])->name('them_thanh_vien');
        Route::delete('/xoa-thanh-vien', [BanCoDocGiaoDucController::class, 'xoaThanhVien'])->name('xoa_thanh_vien');
        Route::put('/cap-nhat-chuc-vu', [BanCoDocGiaoDucController::class, 'capNhatChucVu'])->name('cap_nhat_chuc_vu');

        // Danh sách thành viên
        Route::get('/dieu-hanh-list', [BanCoDocGiaoDucController::class, 'dieuHanhList'])->name('dieu_hanh_list');
        Route::get('/ban-vien-list', [BanCoDocGiaoDucController::class, 'banVienList'])->name('ban_vien_list');

        // Quản lý buổi nhóm
        Route::get('/buoi-nhom', [BanCoDocGiaoDucController::class, 'getBuoiNhomList'])->name('buoi_nhom_list');
        Route::post('/buoi-nhom', [BanCoDocGiaoDucController::class, 'themBuoiNhom'])->name('them_buoi_nhom');
        Route::put('/buoi-nhom/{buoiNhom}', [BanCoDocGiaoDucController::class, 'updateBuoiNhom'])->name('update_buoi_nhom');
        Route::delete('/buoi-nhom/{buoiNhom}', [BanCoDocGiaoDucController::class, 'deleteBuoiNhom'])->name('delete_buoi_nhom');
        Route::post('/luu-diem-danh', [BanCoDocGiaoDucController::class, 'luuDiemDanh'])->name('luu_diem_danh');

        // Quản lý thăm viếng
        Route::post('/them-tham-vieng', [BanCoDocGiaoDucController::class, 'themThamVieng'])->name('them_tham_vieng');
        Route::put('/tham-vieng/{id}', [BanCoDocGiaoDucController::class, 'updateThamVieng'])->name('update_tham_vieng');
        Route::get('/chi-tiet-tham-vieng/{id}', [BanCoDocGiaoDucController::class, 'chiTietThamVieng'])->name('chi_tiet_tham_vieng');
        Route::get('/filter-de-xuat-tham-vieng', [BanCoDocGiaoDucController::class, 'filterDeXuatThamVieng'])->name('filter_de_xuat_tham_vieng');
        Route::get('/filter-tham-vieng', [BanCoDocGiaoDucController::class, 'filterThamVieng'])->name('filter_tham_vieng');

        // Quản lý phân công
        Route::post('/phan-cong-nhiem-vu', [BanCoDocGiaoDucController::class, 'phanCongNhiemVu'])->name('phan_cong_nhiem_vu');
        Route::delete('/xoa-phan-cong/{id}', [BanCoDocGiaoDucController::class, 'xoaPhanCong'])->name('xoa_phan_cong');

        // Báo cáo và thống kê
        Route::post('/luu-bao-cao', [BanCoDocGiaoDucController::class, 'luuBaoCaoBanTrungLao'])->name('luu_bao_cao');
        Route::post('/update-thamdu-trung-lao', [BanCoDocGiaoDucController::class, 'updateThamDuTrungLao'])->name('update_thamdu_trung_lao');
        Route::delete('/xoa-danh-gia/{id}', [BanCoDocGiaoDucController::class, 'xoaDanhGia'])->name('xoa_danh_gia');
        Route::delete('/xoa-kien-nghi/{id}', [BanCoDocGiaoDucController::class, 'xoaKienNghi'])->name('xoa_kien_nghi');
    });

/*
|--------------------------------------------------------------------------
| Web routes cho Ban Trung Lão (giao diện quản lý)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'checkRole:quan_tri,truong_ban'])
    ->prefix('ban-co-doc-giao-duc')
    ->name('_ban_thanh_trang.')
    ->group(function () {
        Route::get('/', [BanCoDocGiaoDucController::class, 'index'])->name('index');
        Route::get('diem-danh', [BanCoDocGiaoDucController::class, 'diemDanh'])->name('diem_danh');
        Route::get('tham-vieng', [BanCoDocGiaoDucController::class, 'thamVieng'])->name('tham_vieng');
        Route::get('phan-cong', [BanCoDocGiaoDucController::class, 'phanCong'])->name('phan_cong');
        Route::get('phan-cong-chi-tiet', [BanCoDocGiaoDucController::class, 'phanCongChiTiet'])->name('phan_cong_chi_tiet');
        Route::get('nhap-lieu-bao-cao', [BanCoDocGiaoDucController::class, 'formBaoCaoBanTrungLao'])->name('nhap_lieu_bao_cao');
        Route::get('bao-cao-ban-co-doc-giao-duc', [BanCoDocGiaoDucController::class, 'baoCaoBanTrungLao'])->name('bao_cao_ban_thanh_trang');

        // Routes cho các chức năng lưu dữ liệu
        Route::post('save-thamdu-trung-lao', [BanCoDocGiaoDucController::class, 'saveThamDuTrungLao'])->name('save_thamdu_trung_lao');
        Route::post('save-danhgia-trung-lao', [BanCoDocGiaoDucController::class, 'saveDanhGiaTrungLao'])->name('save_danhgia_trung_lao');
        Route::post('save-kehoach-trung-lao', [BanCoDocGiaoDucController::class, 'saveKeHoachTrungLao'])->name('save_kehoach_trung_lao');
        Route::post('save-kiennghi-trung-lao', [BanCoDocGiaoDucController::class, 'saveKienNghiTrungLao'])->name('save_kiennghi_trung_lao');

        // API cập nhật nhanh từng dòng
        Route::post('update-thamdu-trung-lao', [BanCoDocGiaoDucController::class, 'updateThamDuTrungLao'])->name('update_thamdu_trung_lao');
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
        Route::get('ban-co-doc-giao-duc', [App\Http\Controllers\BanCoDocGiaoDuc\BaoCaoBanCoDocGiaoDucController::class, 'baoCaoBanTrungLao'])
            ->name('ban_thanh_trang');
    });
