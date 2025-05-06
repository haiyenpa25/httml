<?php

use App\Http\Controllers\BanNganh\BanNganhController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Routes for Ban Ngành
|--------------------------------------------------------------------------
| Defines routes for managing Ban Ngành (Trung Lão, Thanh Tráng, Thanh Niên, Thiếu Nhi Ấu).
| Routes are grouped by ban for clarity, with separate sections for API and web routes.
| Middleware ensures only authorized roles (quan_tri or specific ban leaders) can access.
*/

// General Ban Ngành Routes
Route::prefix('ban-nganh')->group(function () {
    // Displays the overview list of all Ban Ngành
    Route::get('/', [BanNganhController::class, 'list'])
        ->name('_ban_nganh.index');
});

/*
|--------------------------------------------------------------------------
| Ban Trung Lão Routes
|--------------------------------------------------------------------------
| Routes for managing Ban Trung Lão, accessible to quan_tri and truong_ban_trung_lao roles.
*/
Route::prefix('ban-nganh/ban-trung-lao')
    ->middleware(['auth', 'checkRole:quan_tri,truong_ban_trung_lao'])
    ->group(function () {
        // API Routes for data operations
        Route::prefix('api')
            ->name('api.ban_nganh.trung_lao.')
            ->group(function () {
                // Member Management
                Route::post('/them-thanh-vien', [BanNganhController::class, 'themThanhVien'])
                    ->defaults('banType', 'trung_lao')
                    ->name('them_thanh_vien'); // Add a member
                Route::delete('/xoa-thanh-vien', [BanNganhController::class, 'xoaThanhVien'])
                    ->defaults('banType', 'trung_lao')
                    ->name('xoa_thanh_vien'); // Remove a member
                Route::put('/cap-nhat-chuc-vu', [BanNganhController::class, 'capNhatChucVu'])
                    ->defaults('banType', 'trung_lao')
                    ->name('cap_nhat_chuc_vu'); // Update member role

                // Member Lists
                Route::get('/dieu-hanh-list', [BanNganhController::class, 'dieuHanhList'])
                    ->defaults('banType', 'trung_lao')
                    ->name('dieu_hanh_list'); // List of leadership members
                Route::get('/ban-vien-list', [BanNganhController::class, 'banVienList'])
                    ->defaults('banType', 'trung_lao')
                    ->name('ban_vien_list'); // List of regular members

                // Meeting Management
                Route::post('/buoi-nhom', [BanNganhController::class, 'themBuoiNhom'])
                    ->defaults('banType', 'trung_lao')
                    ->name('them_buoi_nhom'); // Create a meeting
                Route::put('/buoi-nhom/{buoiNhom}', [BanNganhController::class, 'updateBuoiNhom'])
                    ->defaults('banType', 'trung_lao')
                    ->name('update_buoi_nhom'); // Update a meeting
                Route::delete('/buoi-nhom/{buoiNhom}', [BanNganhController::class, 'deleteBuoiNhom'])
                    ->defaults('banType', 'trung_lao')
                    ->name('delete_buoi_nhom'); // Delete a meeting
                Route::post('/luu-diem-danh', [BanNganhController::class, 'luuDiemDanh'])
                    ->defaults('banType', 'trung_lao')
                    ->name('luu_diem_danh'); // Save attendance

                // Visitation Management
                Route::post('/them-tham-vieng', [BanNganhController::class, 'themThamVieng'])
                    ->defaults('banType', 'trung_lao')
                    ->name('them_tham_vieng'); // Add a visitation
                Route::put('/tham-vieng/{id}', [BanNganhController::class, 'updateThamVieng'])
                    ->defaults('banType', 'trung_lao')
                    ->name('update_tham_vieng'); // Update a visitation
                Route::get('/chi-tiet-tham-vieng/{id}', [BanNganhController::class, 'chiTietThamVieng'])
                    ->defaults('banType', 'trung_lao')
                    ->name('chi_tiet_tham_vieng'); // View visitation details
                Route::get('/filter-de-xuat-tham-vieng', [BanNganhController::class, 'filterDeXuatThamVieng'])
                    ->defaults('banType', 'trung_lao')
                    ->name('filter_de_xuat_tham_vieng'); // Filter visitation suggestions
                Route::get('/filter-tham-vieng', [BanNganhController::class, 'filterThamVieng'])
                    ->defaults('banType', 'trung_lao')
                    ->name('filter_tham_vieng'); // Filter visitations

                // Task Assignment
                Route::post('/phan-cong-nhiem-vu', [BanNganhController::class, 'phanCongNhiemVu'])
                    ->defaults('banType', 'trung_lao')
                    ->name('phan_cong_nhiem_vu'); // Assign a task
                Route::delete('/xoa-phan-cong/{id}', [BanNganhController::class, 'xoaPhanCong'])
                    ->defaults('banType', 'trung_lao')
                    ->name('xoa_phan_cong'); // Delete a task assignment

                // Reports and Statistics
                Route::post('/luu-bao-cao', [BanNganhController::class, 'luuBaoCao'])
                    ->defaults('banType', 'trung_lao')
                    ->name('luu_bao_cao'); // Save a report
                Route::post('/update-tham-du', [BanNganhController::class, 'updateThamDu'])
                    ->defaults('banType', 'trung_lao')
                    ->name('update_tham_du'); // Update attendance data
                Route::delete('/xoa-danh-gia/{id}', [BanNganhController::class, 'xoaDanhGia'])
                    ->defaults('banType', 'trung_lao')
                    ->name('xoa_danh_gia'); // Delete an evaluation
                Route::delete('/xoa-kien-nghi/{id}', [BanNganhController::class, 'xoaKienNghi'])
                    ->defaults('banType', 'trung_lao')
                    ->name('xoa_kien_nghi'); // Delete a suggestion
            });

        // Web Routes for management interface
        Route::name('_ban_nganh.trung_lao.')
            ->group(function () {
                Route::get('/', [BanNganhController::class, 'index'])
                    ->defaults('banType', 'trung_lao')
                    ->name('index'); // Ban Trung Lão dashboard
                Route::get('/diem-danh', [BanNganhController::class, 'diemDanh'])
                    ->defaults('banType', 'trung_lao')
                    ->name('diem_danh'); // Attendance management
                Route::get('/tham-vieng', [BanNganhController::class, 'thamVieng'])
                    ->defaults('banType', 'trung_lao')
                    ->name('tham_vieng'); // Visitation management
                Route::get('/phan-cong', [BanNganhController::class, 'phanCong'])
                    ->defaults('banType', 'trung_lao')
                    ->name('phan_cong'); // Task assignment overview
                Route::get('/phan-cong-chi-tiet', [BanNganhController::class, 'phanCongChiTiet'])
                    ->defaults('banType', 'trung_lao')
                    ->name('phan_cong_chi_tiet'); // Detailed task assignment
                Route::get('/nhap-lieu-bao-cao', [BanNganhController::class, 'formBaoCaoBan'])
                    ->defaults('banType', 'trung_lao')
                    ->name('nhap_lieu_bao_cao'); // Report input form
                Route::get('/bao-cao', [BanNganhController::class, 'baoCaoBan'])
                    ->defaults('banType', 'trung_lao')
                    ->name('bao_cao'); // Ban report overview

                // Data Saving Routes
                Route::post('/save-tham-du', [BanNganhController::class, 'saveThamDu'])
                    ->defaults('banType', 'trung_lao')
                    ->name('save_tham_du'); // Save attendance data
                Route::post('/save-danh-gia', [BanNganhController::class, 'saveDanhGia'])
                    ->defaults('banType', 'trung_lao')
                    ->name('save_danh_gia'); // Save evaluation
                Route::post('/save-ke-hoach', [BanNganhController::class, 'saveKeHoach'])
                    ->defaults('banType', 'trung_lao')
                    ->name('save_ke_hoach'); // Save plan
                Route::post('/save-kien-nghi', [BanNganhController::class, 'saveKienNghi'])
                    ->defaults('banType', 'trung_lao')
                    ->name('save_kien_nghi'); // Save suggestion
            });
    });

/*
|--------------------------------------------------------------------------
| Ban Thanh Tráng Routes
|--------------------------------------------------------------------------
| Routes for managing Ban Thanh Tráng, accessible to quan_tri and truong_ban_thanh_trang roles.
*/
Route::prefix('ban-nganh/ban-thanh-trang')
    ->middleware(['auth', 'checkRole:quan_tri,truong_ban_thanh_trang'])
    ->group(function () {
        // API Routes for data operations
        Route::prefix('api')
            ->name('api.ban_nganh.thanh_trang.')
            ->group(function () {
                // Member Management
                Route::post('/them-thanh-vien', [BanNganhController::class, 'themThanhVien'])
                    ->defaults('banType', 'thanh_trang')
                    ->name('them_thanh_vien');
                Route::delete('/xoa-thanh-vien', [BanNganhController::class, 'xoaThanhVien'])
                    ->defaults('banType', 'thanh_trang')
                    ->name('xoa_thanh_vien');
                Route::put('/cap-nhat-chuc-vu', [BanNganhController::class, 'capNhatChucVu'])
                    ->defaults('banType', 'thanh_trang')
                    ->name('cap_nhat_chuc_vu');

                // Member Lists
                Route::get('/dieu-hanh-list', [BanNganhController::class, 'dieuHanhList'])
                    ->defaults('banType', 'thanh_trang')
                    ->name('dieu_hanh_list');
                Route::get('/ban-vien-list', [BanNganhController::class, 'banVienList'])
                    ->defaults('banType', 'thanh_trang')
                    ->name('ban_vien_list');

                // Meeting Management
                Route::post('/buoi-nhom', [BanNganhController::class, 'themBuoiNhom'])
                    ->defaults('banType', 'thanh_trang')
                    ->name('them_buoi_nhom');
                Route::put('/buoi-nhom/{buoiNhom}', [BanNganhController::class, 'updateBuoiNhom'])
                    ->defaults('banType', 'thanh_trang')
                    ->name('update_buoi_nhom');
                Route::delete('/buoi-nhom/{buoiNhom}', [BanNganhController::class, 'deleteBuoiNhom'])
                    ->defaults('banType', 'thanh_trang')
                    ->name('delete_buoi_nhom');
                Route::post('/luu-diem-danh', [BanNganhController::class, 'luuDiemDanh'])
                    ->defaults('banType', 'thanh_trang')
                    ->name('luu_diem_danh');

                // Visitation Management
                Route::post('/them-tham-vieng', [BanNganhController::class, 'themThamVieng'])
                    ->defaults('banType', 'thanh_trang')
                    ->name('them_tham_vieng');
                Route::put('/tham-vieng/{id}', [BanNganhController::class, 'updateThamVieng'])
                    ->defaults('banType', 'thanh_trang')
                    ->name('update_tham_vieng');
                Route::get('/chi-tiet-tham-vieng/{id}', [BanNganhController::class, 'chiTietThamVieng'])
                    ->defaults('banType', 'thanh_trang')
                    ->name('chi_tiet_tham_vieng');
                Route::get('/filter-de-xuat-tham-vieng', [BanNganhController::class, 'filterDeXuatThamVieng'])
                    ->defaults('banType', 'thanh_trang')
                    ->name('filter_de_xuat_tham_vieng');
                Route::get('/filter-tham-vieng', [BanNganhController::class, 'filterThamVieng'])
                    ->defaults('banType', 'thanh_trang')
                    ->name('filter_tham_vieng');

                // Task Assignment
                Route::post('/phan-cong-nhiem-vu', [BanNganhController::class, 'phanCongNhiemVu'])
                    ->defaults('banType', 'thanh_trang')
                    ->name('phan_cong_nhiem_vu');
                Route::delete('/xoa-phan-cong/{id}', [BanNganhController::class, 'xoaPhanCong'])
                    ->defaults('banType', 'thanh_trang')
                    ->name('xoa_phan_cong');

                // Reports and Statistics
                Route::post('/luu-bao-cao', [BanNganhController::class, 'luuBaoCao'])
                    ->defaults('banType', 'thanh_trang')
                    ->name('luu_bao_cao');
                Route::post('/update-tham-du', [BanNganhController::class, 'updateThamDu'])
                    ->defaults('banType', 'thanh_trang')
                    ->name('update_tham_du');
                Route::delete('/xoa-danh-gia/{id}', [BanNganhController::class, 'xoaDanhGia'])
                    ->defaults('banType', 'thanh_trang')
                    ->name('xoa_danh_gia');
                Route::delete('/xoa-kien-nghi/{id}', [BanNganhController::class, 'xoaKienNghi'])
                    ->defaults('banType', 'thanh_trang')
                    ->name('xoa_kien_nghi');
            });

        // Web Routes for management interface
        Route::name('_ban_nganh.thanh_trang.')
            ->group(function () {
                Route::get('/', [BanNganhController::class, 'index'])
                    ->defaults('banType', 'thanh_trang')
                    ->name('index');
                Route::get('/diem-danh', [BanNganhController::class, 'diemDanh'])
                    ->defaults('banType', 'thanh_trang')
                    ->name('diem_danh');
                Route::get('/tham-vieng', [BanNganhController::class, 'thamVieng'])
                    ->defaults('banType', 'thanh_trang')
                    ->name('tham_vieng');
                Route::get('/phan-cong', [BanNganhController::class, 'phanCong'])
                    ->defaults('banType', 'thanh_trang')
                    ->name('phan_cong');
                Route::get('/phan-cong-chi-tiet', [BanNganhController::class, 'phanCongChiTiet'])
                    ->defaults('banType', 'thanh_trang')
                    ->name('phan_cong_chi_tiet');
                Route::get('/nhap-lieu-bao-cao', [BanNganhController::class, 'formBaoCaoBan'])
                    ->defaults('banType', 'thanh_trang')
                    ->name('nhap_lieu_bao_cao');
                Route::get('/bao-cao', [BanNganhController::class, 'baoCaoBan'])
                    ->defaults('banType', 'thanh_trang')
                    ->name('bao_cao');

                // Data Saving Routes
                Route::post('/save-tham-du', [BanNganhController::class, 'saveThamDu'])
                    ->defaults('banType', 'thanh_trang')
                    ->name('save_tham_du');
                Route::post('/save-danh-gia', [BanNganhController::class, 'saveDanhGia'])
                    ->defaults('banType', 'thanh_trang')
                    ->name('save_danh_gia');
                Route::post('/save-ke-hoach', [BanNganhController::class, 'saveKeHoach'])
                    ->defaults('banType', 'thanh_trang')
                    ->name('save_ke_hoach');
                Route::post('/save-kien-nghi', [BanNganhController::class, 'saveKienNghi'])
                    ->defaults('banType', 'thanh_trang')
                    ->name('save_kien_nghi');
            });
    });

/*
|--------------------------------------------------------------------------
| Ban Thanh Niên Routes
|--------------------------------------------------------------------------
| Routes for managing Ban Thanh Niên, accessible to quan_tri and truong_ban_thanh_nien roles.
*/
Route::prefix('ban-nganh/ban-thanh-nien')
    ->middleware(['auth', 'checkRole:quan_tri,truong_ban_thanh_nien'])
    ->group(function () {
        // API Routes for data operations
        Route::prefix('api')
            ->name('api.ban_nganh.thanh_nien.')
            ->group(function () {
                // Member Management
                Route::post('/them-thanh-vien', [BanNganhController::class, 'themThanhVien'])
                    ->defaults('banType', 'thanh_nien')
                    ->name('them_thanh_vien');
                Route::delete('/xoa-thanh-vien', [BanNganhController::class, 'xoaThanhVien'])
                    ->defaults('banType', 'thanh_nien')
                    ->name('xoa_thanh_vien');
                Route::put('/cap-nhat-chuc-vu', [BanNganhController::class, 'capNhatChucVu'])
                    ->defaults('banType', 'thanh_nien')
                    ->name('cap_nhat_chuc_vu');

                // Member Lists
                Route::get('/dieu-hanh-list', [BanNganhController::class, 'dieuHanhList'])
                    ->defaults('banType', 'thanh_nien')
                    ->name('dieu_hanh_list');
                Route::get('/ban-vien-list', [BanNganhController::class, 'banVienList'])
                    ->defaults('banType', 'thanh_nien')
                    ->name('ban_vien_list');

                // Meeting Management
                Route::post('/buoi-nhom', [BanNganhController::class, 'themBuoiNhom'])
                    ->defaults('banType', 'thanh_nien')
                    ->name('them_buoi_nhom');
                Route::put('/buoi-nhom/{buoiNhom}', [BanNganhController::class, 'updateBuoiNhom'])
                    ->defaults('banType', 'thanh_nien')
                    ->name('update_buoi_nhom');
                Route::delete('/buoi-nhom/{buoiNhom}', [BanNganhController::class, 'deleteBuoiNhom'])
                    ->defaults('banType', 'thanh_nien')
                    ->name('delete_buoi_nhom');
                Route::post('/luu-diem-danh', [BanNganhController::class, 'luuDiemDanh'])
                    ->defaults('banType', 'thanh_nien')
                    ->name('luu_diem_danh');

                // Visitation Management
                Route::post('/them-tham-vieng', [BanNganhController::class, 'themThamVieng'])
                    ->defaults('banType', 'thanh_nien')
                    ->name('them_tham_vieng');
                Route::put('/tham-vieng/{id}', [BanNganhController::class, 'updateThamVieng'])
                    ->defaults('banType', 'thanh_nien')
                    ->name('update_tham_vieng');
                Route::get('/chi-tiet-tham-vieng/{id}', [BanNganhController::class, 'chiTietThamVieng'])
                    ->defaults('banType', 'thanh_nien')
                    ->name('chi_tiet_tham_vieng');
                Route::get('/filter-de-xuat-tham-vieng', [BanNganhController::class, 'filterDeXuatThamVieng'])
                    ->defaults('banType', 'thanh_nien')
                    ->name('filter_de_xuat_tham_vieng');
                Route::get('/filter-tham-vieng', [BanNganhController::class, 'filterThamVieng'])
                    ->defaults('banType', 'thanh_nien')
                    ->name('filter_tham_vieng');

                // Task Assignment
                Route::post('/phan-cong-nhiem-vu', [BanNganhController::class, 'phanCongNhiemVu'])
                    ->defaults('banType', 'thanh_nien')
                    ->name('phan_cong_nhiem_vu');
                Route::delete('/xoa-phan-cong/{id}', [BanNganhController::class, 'xoaPhanCong'])
                    ->defaults('banType', 'thanh_nien')
                    ->name('xoa_phan_cong');

                // Reports and Statistics
                Route::post('/luu-bao-cao', [BanNganhController::class, 'luuBaoCao'])
                    ->defaults('banType', 'thanh_nien')
                    ->name('luu_bao_cao');
                Route::post('/update-tham-du', [BanNganhController::class, 'updateThamDu'])
                    ->defaults('banType', 'thanh_nien')
                    ->name('update_tham_du');
                Route::delete('/xoa-danh-gia/{id}', [BanNganhController::class, 'xoaDanhGia'])
                    ->defaults('banType', 'thanh_nien')
                    ->name('xoa_danh_gia');
                Route::delete('/xoa-kien-nghi/{id}', [BanNganhController::class, 'xoaKienNghi'])
                    ->defaults('banType', 'thanh_nien')
                    ->name('xoa_kien_nghi');
            });

        // Web Routes for management interface
        Route::name('_ban_nganh.thanh_nien.')
            ->group(function () {
                Route::get('/', [BanNganhController::class, 'index'])
                    ->defaults('banType', 'thanh_nien')
                    ->name('index');
                Route::get('/diem-danh', [BanNganhController::class, 'diemDanh'])
                    ->defaults('banType', 'thanh_nien')
                    ->name('diem_danh');
                Route::get('/tham-vieng', [BanNganhController::class, 'thamVieng'])
                    ->defaults('banType', 'thanh_nien')
                    ->name('tham_vieng');
                Route::get('/phan-cong', [BanNganhController::class, 'phanCong'])
                    ->defaults('banType', 'thanh_nien')
                    ->name('phan_cong');
                Route::get('/phan-cong-chi-tiet', [BanNganhController::class, 'phanCongChiTiet'])
                    ->defaults('banType', 'thanh_nien')
                    ->name('phan_cong_chi_tiet');
                Route::get('/nhap-lieu-bao-cao', [BanNganhController::class, 'formBaoCaoBan'])
                    ->defaults('banType', 'thanh_nien')
                    ->name('nhap_lieu_bao_cao');
                Route::get('/bao-cao', [BanNganhController::class, 'baoCaoBan'])
                    ->defaults('banType', 'thanh_nien')
                    ->name('bao_cao');

                // Data Saving Routes
                Route::post('/save-tham-du', [BanNganhController::class, 'saveThamDu'])
                    ->defaults('banType', 'thanh_nien')
                    ->name('save_tham_du');
                Route::post('/save-danh-gia', [BanNganhController::class, 'saveDanhGia'])
                    ->defaults('banType', 'thanh_nien')
                    ->name('save_danh_gia');
                Route::post('/save-ke-hoach', [BanNganhController::class, 'saveKeHoach'])
                    ->defaults('banType', 'thanh_nien')
                    ->name('save_ke_hoach');
                Route::post('/save-kien-nghi', [BanNganhController::class, 'saveKienNghi'])
                    ->defaults('banType', 'thanh_nien')
                    ->name('save_kien_nghi');
            });
    });

/*
|--------------------------------------------------------------------------
| Ban Thiếu Nhi Ấu Routes
|--------------------------------------------------------------------------
| Routes for managing Ban Thiếu Nhi Ấu, accessible to quan_tri and truong_ban_thieu_nhi roles.
| Note: Aligned with sidebar naming (_ban_thieu_nhi_au).
*/
Route::prefix('ban-nganh/ban-thieu-nhi-au')
    ->middleware(['auth', 'checkRole:quan_tri,truong_ban_thieu_nhi'])
    ->group(function () {
        // API Routes for data operations
        Route::prefix('api')
            ->name('api.ban_nganh.thieu_nhi_au.')
            ->group(function () {
                // Member Management
                Route::post('/them-thanh-vien', [BanNganhController::class, 'themThanhVien'])
                    ->defaults('banType', 'thieu_nhi_au')
                    ->name('them_thanh_vien');
                Route::delete('/xoa-thanh-vien', [BanNganhController::class, 'xoaThanhVien'])
                    ->defaults('banType', 'thieu_nhi_au')
                    ->name('xoa_thanh_vien');
                Route::put('/cap-nhat-chuc-vu', [BanNganhController::class, 'capNhatChucVu'])
                    ->defaults('banType', 'thieu_nhi_au')
                    ->name('cap_nhat_chuc_vu');

                // Member Lists
                Route::get('/dieu-hanh-list', [BanNganhController::class, 'dieuHanhList'])
                    ->defaults('banType', 'thieu_nhi_au')
                    ->name('dieu_hanh_list');
                Route::get('/ban-vien-list', [BanNganhController::class, 'banVienList'])
                    ->defaults('banType', 'thieu_nhi_au')
                    ->name('ban_vien_list');

                // Meeting Management
                Route::post('/buoi-nhom', [BanNganhController::class, 'themBuoiNhom'])
                    ->defaults('banType', 'thieu_nhi_au')
                    ->name('them_buoi_nhom');
                Route::put('/buoi-nhom/{buoiNhom}', [BanNganhController::class, 'updateBuoiNhom'])
                    ->defaults('banType', 'thieu_nhi_au')
                    ->name('update_buoi_nhom');
                Route::delete('/buoi-nhom/{buoiNhom}', [BanNganhController::class, 'deleteBuoiNhom'])
                    ->defaults('banType', 'thieu_nhi_au')
                    ->name('delete_buoi_nhom');
                Route::post('/luu-diem-danh', [BanNganhController::class, 'luuDiemDanh'])
                    ->defaults('banType', 'thieu_nhi_au')
                    ->name('luu_diem_danh');

                // Visitation Management
                Route::post('/them-tham-vieng', [BanNganhController::class, 'themThamVieng'])
                    ->defaults('banType', 'thieu_nhi_au')
                    ->name('them_tham_vieng');
                Route::put('/tham-vieng/{id}', [BanNganhController::class, 'updateThamVieng'])
                    ->defaults('banType', 'thieu_nhi_au')
                    ->name('update_tham_vieng');
                Route::get('/chi-tiet-tham-vieng/{id}', [BanNganhController::class, 'chiTietThamVieng'])
                    ->defaults('banType', 'thieu_nhi_au')
                    ->name('chi_tiet_tham_vieng');
                Route::get('/filter-de-xuat-tham-vieng', [BanNganhController::class, 'filterDeXuatThamVieng'])
                    ->defaults('banType', 'thieu_nhi_au')
                    ->name('filter_de_xuat_tham_vieng');
                Route::get('/filter-tham-vieng', [BanNganhController::class, 'filterThamVieng'])
                    ->defaults('banType', 'thieu_nhi_au')
                    ->name('filter_tham_vieng');

                // Task Assignment
                Route::post('/phan-cong-nhiem-vu', [BanNganhController::class, 'phanCongNhiemVu'])
                    ->defaults('banType', 'thieu_nhi_au')
                    ->name('phan_cong_nhiem_vu');
                Route::delete('/xoa-phan-cong/{id}', [BanNganhController::class, 'xoaPhanCong'])
                    ->defaults('banType', 'thieu_nhi_au')
                    ->name('xoa_phan_cong');

                // Reports and Statistics
                Route::post('/luu-bao-cao', [BanNganhController::class, 'luuBaoCao'])
                    ->defaults('banType', 'thieu_nhi_au')
                    ->name('luu_bao_cao');
                Route::post('/update-tham-du', [BanNganhController::class, 'updateThamDu'])
                    ->defaults('banType', 'thieu_nhi_au')
                    ->name('update_tham_du');
                Route::delete('/xoa-danh-gia/{id}', [BanNganhController::class, 'xoaDanhGia'])
                    ->defaults('banType', 'thieu_nhi_au')
                    ->name('xoa_danh_gia');
                Route::delete('/xoa-kien-nghi/{id}', [BanNganhController::class, 'xoaKienNghi'])
                    ->defaults('banType', 'thieu_nhi_au')
                    ->name('xoa_kien_nghi');
            });

        // Web Routes for management interface
        Route::name('_ban_nganh.thieu_nhi_au.')
            ->group(function () {
                Route::get('/', [BanNganhController::class, 'index'])
                    ->defaults('banType', 'thieu_nhi_au')
                    ->name('index');
                Route::get('/diem-danh', [BanNganhController::class, 'diemDanh'])
                    ->defaults('banType', 'thieu_nhi_au')
                    ->name('diem_danh');
                Route::get('/tham-vieng', [BanNganhController::class, 'thamVieng'])
                    ->defaults('banType', 'thieu_nhi_au')
                    ->name('tham_vieng');
                Route::get('/phan-cong', [BanNganhController::class, 'phanCong'])
                    ->defaults('banType', 'thieu_nhi_au')
                    ->name('phan_cong');
                Route::get('/phan-cong-chi-tiet', [BanNganhController::class, 'phanCongChiTiet'])
                    ->defaults('banType', 'thieu_nhi_au')
                    ->name('phan_cong_chi_tiet');
                Route::get('/nhap-lieu-bao-cao', [BanNganhController::class, 'formBaoCaoBan'])
                    ->defaults('banType', 'thieu_nhi_au')
                    ->name('nhap_lieu_bao_cao');
                Route::get('/bao-cao', [BanNganhController::class, 'baoCaoBan'])
                    ->defaults('banType', 'thieu_nhi_au')
                    ->name('bao_cao');

                // Data Saving Routes
                Route::post('/save-tham-du', [BanNganhController::class, 'saveThamDu'])
                    ->defaults('banType', 'thieu_nhi_au')
                    ->name('save_tham_du');
                Route::post('/save-danh-gia', [BanNganhController::class, 'saveDanhGia'])
                    ->defaults('banType', 'thieu_nhi_au')
                    ->name('save_danh_gia');
                Route::post('/save-ke-hoach', [BanNganhController::class, 'saveKeHoach'])
                    ->defaults('banType', 'thieu_nhi_au')
                    ->name('save_ke_hoach');
                Route::post('/save-kien-nghi', [BanNganhController::class, 'saveKienNghi'])
                    ->defaults('banType', 'thieu_nhi_au')
                    ->name('save_kien_nghi');
            });
    });

/*
|--------------------------------------------------------------------------
| Báo Cáo Routes
|--------------------------------------------------------------------------
| Routes for generating reports for each Ban Ngành, accessible to quan_tri and respective ban leaders.
*/
Route::prefix('bao-cao')
    ->middleware(['auth', 'checkRole:quan_tri'])
    ->name('_bao_cao.')
    ->group(function () {
        Route::get('/ban-nganh/ban-trung-lao', [BanNganhController::class, 'baoCaoBan'])
            ->defaults('banType', 'trung_lao')
            ->name('ban_nganh.trung_lao')
            ->middleware('checkRole:quan_tri,truong_ban_trung_lao');

        Route::get('/ban-nganh/ban-thanh-trang', [BanNganhController::class, 'baoCaoBan'])
            ->defaults('banType', 'thanh_trang')
            ->name('ban_nganh.thanh_trang')
            ->middleware('checkRole:quan_tri,truong_ban_thanh_trang');

        Route::get('/ban-nganh/ban-thanh-nien', [BanNganhController::class, 'baoCaoBan'])
            ->defaults('banType', 'thanh_nien')
            ->name('ban_nganh.thanh_nien')
            ->middleware('checkRole:quan_tri,truong_ban_thanh_nien');

        Route::get('/ban-nganh/ban-thieu-nhi-au', [BanNganhController::class, 'baoCaoBan'])
            ->defaults('banType', 'thieu_nhi_au')
            ->name('ban_nganh.thieu_nhi_au')
            ->middleware('checkRole:quan_tri,truong_ban_thieu_nhi');
    });
