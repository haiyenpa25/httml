<?php

use App\Http\Controllers\BanNganh\BanNganhController;
use Illuminate\Support\Facades\Route;

// General Ban Ngành Routes
Route::prefix('ban-nganh')->group(function () {
    // Displays the overview list of all Ban Ngành
    Route::get('/{banType}', [BanNganhController::class, 'list'])
        ->middleware(['auth', 'checkPermission:view-ban-nganh'])
        ->name('_ban_nganh.index');
});

// Ban Trung Lão Routes
Route::prefix('ban-nganh/ban-trung-lao')
    ->middleware(['auth'])
    ->group(function () {
        // API Routes for data operations
        Route::prefix('api')
            ->name('api.ban_nganh.trung_lao.')
            ->group(function () {
                // Member Management
                Route::post('/them-thanh-vien', [BanNganhController::class, 'themThanhVien'])
                    ->middleware('checkPermission:manage-thanh-vien-ban-nganh-trung-lao')
                    ->defaults('banType', 'trung_lao')
                    ->name('them_thanh_vien');
                Route::delete('/xoa-thanh-vien', [BanNganhController::class, 'xoaThanhVien'])
                    ->middleware('checkPermission:manage-thanh-vien-ban-nganh-trung-lao')
                    ->defaults('banType', 'trung_lao')
                    ->name('xoa_thanh_vien');
                Route::put('/cap-nhat-chuc-vu', [BanNganhController::class, 'capNhatChucVu'])
                    ->middleware('checkPermission:manage-thanh-vien-ban-nganh-trung-lao')
                    ->defaults('banType', 'trung_lao')
                    ->name('cap_nhat_chuc_vu');
                Route::get('/chi-tiet-thanh-vien', [BanNganhController::class, 'chiTietThanhVien'])
                    ->middleware('checkPermission:view-thanh-vien-ban-nganh-trung-lao')
                    ->defaults('banType', 'trung_lao')
                    ->name('chi_tiet_thanh_vien');

                // Member Lists
                Route::get('/dieu-hanh-list', [BanNganhController::class, 'dieuHanhList'])
                    ->middleware('checkPermission:view-thanh-vien-ban-nganh-trung-lao')
                    ->defaults('banType', 'trung_lao')
                    ->name('dieu_hanh_list');
                Route::get('/ban-vien-list', [BanNganhController::class, 'banVienList'])
                    ->middleware('checkPermission:view-thanh-vien-ban-nganh-trung-lao')
                    ->defaults('banType', 'trung_lao')
                    ->name('ban_vien_list');

                // Meeting Management
                Route::post('/buoi-nhom', [BanNganhController::class, 'themBuoiNhom'])
                    ->middleware('checkPermission:manage-buoi-nhom-ban-nganh-trung-lao')
                    ->defaults('banType', 'trung_lao')
                    ->name('them_buoi_nhom');
                Route::put('/buoi-nhom/{buoiNhom}', [BanNganhController::class, 'updateBuoiNhom'])
                    ->middleware('checkPermission:manage-buoi-nhom-ban-nganh-trung-lao')
                    ->defaults('banType', 'trung_lao')
                    ->name('update_buoi_nhom');
                Route::delete('/buoi-nhom/{buoiNhom}', [BanNganhController::class, 'deleteBuoiNhom'])
                    ->middleware('checkPermission:manage-buoi-nhom-ban-nganh-trung-lao')
                    ->defaults('banType', 'trung_lao')
                    ->name('delete_buoi_nhom');
                Route::post('/luu-diem-danh', [BanNganhController::class, 'luuDiemDanh'])
                    ->middleware('checkPermission:manage-buoi-nhom-ban-nganh-trung-lao')
                    ->defaults('banType', 'trung_lao')
                    ->name('luu_diem_danh');

                // Visitation Management
                Route::post('/them-tham-vieng', [BanNganhController::class, 'themThamVieng'])
                    ->middleware('checkPermission:manage-tham-vieng-ban-nganh-trung-lao')
                    ->defaults('banType', 'trung_lao')
                    ->name('them_tham_vieng');
                Route::put('/tham-vieng/{id}', [BanNganhController::class, 'updateThamVieng'])
                    ->middleware('checkPermission:manage-tham-vieng-ban-nganh-trung-lao')
                    ->defaults('banType', 'trung_lao')
                    ->name('update_tham_vieng');
                Route::get('/chi-tiet-tham-vieng/{id}', [BanNganhController::class, 'chiTietThamVieng'])
                    ->middleware('checkPermission:manage-tham-vieng-ban-nganh-trung-lao')
                    ->defaults('banType', 'trung_lao')
                    ->name('chi_tiet_tham_vieng');
                Route::get('/filter-de-xuat-tham-vieng', [BanNganhController::class, 'filterDeXuatThamVieng'])
                    ->middleware('checkPermission:manage-tham-vieng-ban-nganh-trung-lao')
                    ->defaults('banType', 'trung_lao')
                    ->name('filter_de_xuat_tham_vieng');
                Route::get('/filter-tham-vieng', [BanNganhController::class, 'filterThamVieng'])
                    ->middleware('checkPermission:manage-tham-vieng-ban-nganh-trung-lao')
                    ->defaults('banType', 'trung_lao')
                    ->name('filter_tham_vieng');

                // Task Assignment
                Route::post('/phan-cong-nhiem-vu', [BanNganhController::class, 'phanCongNhiemVu'])
                    ->middleware('checkPermission:manage-phan-cong-ban-nganh-trung-lao')
                    ->defaults('banType', 'trung_lao')
                    ->name('phan_cong_nhiem_vu');
                Route::delete('/xoa-phan-cong/{id}', [BanNganhController::class, 'xoaPhanCong'])
                    ->middleware('checkPermission:manage-phan-cong-ban-nganh-trung-lao')
                    ->defaults('banType', 'trung_lao')
                    ->name('xoa_phan_cong');

                // Reports and Statistics
                Route::post('/luu-bao-cao', [BanNganhController::class, 'luuBaoCao'])
                    ->middleware('checkPermission:manage-bao-cao-ban-nganh-trung-lao')
                    ->defaults('banType', 'trung_lao')
                    ->name('luu_bao_cao');
                Route::post('/update-tham-du', [BanNganhController::class, 'updateThamDu'])
                    ->middleware('checkPermission:manage-bao-cao-ban-nganh-trung-lao')
                    ->defaults('banType', 'trung_lao')
                    ->name('update_tham_du');
                Route::delete('/xoa-danh-gia/{id}', [BanNganhController::class, 'xoaDanhGia'])
                    ->middleware('checkPermission:manage-bao-cao-ban-nganh-trung-lao')
                    ->defaults('banType', 'trung_lao')
                    ->name('xoa_danh_gia');
                Route::delete('/xoa-kien-nghi/{id}', [BanNganhController::class, 'xoaKienNghi'])
                    ->middleware('checkPermission:manage-bao-cao-ban-nganh-trung-lao')
                    ->defaults('banType', 'trung_lao')
                    ->name('xoa_kien_nghi');
            });

        // Web Routes for management interface
        Route::name('_ban_nganh.trung_lao.')
            ->group(function () {
                Route::get('/', [BanNganhController::class, 'index'])
                    ->middleware('checkPermission:view-ban-nganh-trung-lao')
                    ->defaults('banType', 'trung_lao')
                    ->name('index');
                Route::get('/diem-danh', [BanNganhController::class, 'diemDanh'])
                    ->middleware('checkPermission:diem-danh-ban-nganh-trung-lao')
                    ->defaults('banType', 'trung_lao')
                    ->name('diem_danh');
                Route::get('/tham-vieng', [BanNganhController::class, 'thamVieng'])
                    ->middleware('checkPermission:tham-vieng-ban-nganh-trung-lao')
                    ->defaults('banType', 'trung_lao')
                    ->name('tham_vieng');
                Route::get('/phan-cong', [BanNganhController::class, 'phanCong'])
                    ->middleware('checkPermission:phan-cong-ban-nganh-trung-lao')
                    ->defaults('banType', 'trung_lao')
                    ->name('phan_cong');
                Route::get('/phan-cong-chi-tiet', [BanNganhController::class, 'phanCongChiTiet'])
                    ->middleware('checkPermission:phan-cong-chi-tiet-ban-nganh-trung-lao')
                    ->defaults('banType', 'trung_lao')
                    ->name('phan_cong_chi_tiet');
                Route::get('/nhap-lieu-bao-cao', [BanNganhController::class, 'formBaoCaoBan'])
                    ->middleware('checkPermission:nhap-lieu-bao-cao-ban-nganh-trung-lao')
                    ->defaults('banType', 'trung_lao')
                    ->name('nhap_lieu_bao_cao');
                Route::get('/bao-cao', [BanNganhController::class, 'baoCaoBan'])
                    ->middleware('checkPermission:bao-cao-ban-nganh-trung-lao')
                    ->defaults('banType', 'trung_lao')
                    ->name('bao_cao');

                // Data Saving Routes
                Route::post('/save-tham-du', [BanNganhController::class, 'saveThamDu'])
                    ->middleware('checkPermission:manage-bao-cao-ban-nganh-trung-lao')
                    ->defaults('banType', 'trung_lao')
                    ->name('save_tham_du');
                Route::post('/save-danh-gia', [BanNganhController::class, 'saveDanhGia'])
                    ->middleware('checkPermission:manage-bao-cao-ban-nganh-trung-lao')
                    ->defaults('banType', 'trung_lao')
                    ->name('save_danh_gia');
                Route::post('/save-ke-hoach', [BanNganhController::class, 'saveKeHoach'])
                    ->middleware('checkPermission:manage-bao-cao-ban-nganh-trung-lao')
                    ->defaults('banType', 'trung_lao')
                    ->name('save_ke_hoach');
                Route::post('/save-kien-nghi', [BanNganhController::class, 'saveKienNghi'])
                    ->middleware('checkPermission:manage-bao-cao-ban-nganh-trung-lao')
                    ->defaults('banType', 'trung_lao')
                    ->name('save_kien_nghi');
            });
    });

// Ban Thanh Tráng Routes
Route::prefix('ban-nganh/ban-thanh-trang')
    ->middleware(['auth'])
    ->group(function () {
        // API Routes for data operations
        Route::prefix('api')
            ->name('api.ban_nganh.thanh_trang.')
            ->group(function () {
                // Member Management
                Route::post('/them-thanh-vien', [BanNganhController::class, 'themThanhVien'])
                    ->middleware('checkPermission:manage-thanh-vien-ban-nganh-thanh-trang')
                    ->defaults('banType', 'thanh_trang')
                    ->name('them_thanh_vien');
                Route::delete('/xoa-thanh-vien', [BanNganhController::class, 'xoaThanhVien'])
                    ->middleware('checkPermission:manage-thanh-vien-ban-nganh-thanh-trang')
                    ->defaults('banType', 'thanh_trang')
                    ->name('xoa_thanh_vien');
                Route::put('/cap-nhat-chuc-vu', [BanNganhController::class, 'capNhatChucVu'])
                    ->middleware('checkPermission:manage-thanh-vien-ban-nganh-thanh-trang')
                    ->defaults('banType', 'thanh_trang')
                    ->name('cap_nhat_chuc_vu');
                Route::get('/chi-tiet-thanh-vien', [BanNganhController::class, 'chiTietThanhVien'])
                    ->middleware('checkPermission:view-thanh-vien-ban-nganh-thanh-trang')
                    ->defaults('banType', 'thanh_trang')
                    ->name('chi_tiet_thanh_vien');

                // Member Lists
                Route::get('/dieu-hanh-list', [BanNganhController::class, 'dieuHanhList'])
                    ->middleware('checkPermission:view-thanh-vien-ban-nganh-thanh-trang')
                    ->defaults('banType', 'thanh_trang')
                    ->name('dieu_hanh_list');
                Route::get('/ban-vien-list', [BanNganhController::class, 'banVienList'])
                    ->middleware('checkPermission:view-thanh-vien-ban-nganh-thanh-trang')
                    ->defaults('banType', 'thanh_trang')
                    ->name('ban_vien_list');

                // Meeting Management
                Route::post('/buoi-nhom', [BanNganhController::class, 'themBuoiNhom'])
                    ->middleware('checkPermission:manage-buoi-nhom-ban-nganh-thanh-trang')
                    ->defaults('banType', 'thanh_trang')
                    ->name('them_buoi_nhom');
                Route::put('/buoi-nhom/{buoiNhom}', [BanNganhController::class, 'updateBuoiNhom'])
                    ->middleware('checkPermission:manage-buoi-nhom-ban-nganh-thanh-trang')
                    ->defaults('banType', 'thanh_trang')
                    ->name('update_buoi_nhom');
                Route::delete('/buoi-nhom/{buoiNhom}', [BanNganhController::class, 'deleteBuoiNhom'])
                    ->middleware('checkPermission:manage-buoi-nhom-ban-nganh-thanh-trang')
                    ->defaults('banType', 'thanh_trang')
                    ->name('delete_buoi_nhom');
                Route::post('/luu-diem-danh', [BanNganhController::class, 'luuDiemDanh'])
                    ->middleware('checkPermission:manage-buoi-nhom-ban-nganh-thanh-trang')
                    ->defaults('banType', 'thanh_trang')
                    ->name('luu_diem_danh');

                // Visitation Management
                Route::post('/them-tham-vieng', [BanNganhController::class, 'themThamVieng'])
                    ->middleware('checkPermission:manage-tham-vieng-ban-nganh-thanh-trang')
                    ->defaults('banType', 'thanh_trang')
                    ->name('them_tham_vieng');
                Route::put('/tham-vieng/{id}', [BanNganhController::class, 'updateThamVieng'])
                    ->middleware('checkPermission:manage-tham-vieng-ban-nganh-thanh-trang')
                    ->defaults('banType', 'thanh_trang')
                    ->name('update_tham_vieng');
                Route::get('/chi-tiet-tham-vieng/{id}', [BanNganhController::class, 'chiTietThamVieng'])
                    ->middleware('checkPermission:manage-tham-vieng-ban-nganh-thanh-trang')
                    ->defaults('banType', 'thanh_trang')
                    ->name('chi_tiet_tham_vieng');
                Route::get('/filter-de-xuat-tham-vieng', [BanNganhController::class, 'filterDeXuatThamVieng'])
                    ->middleware('checkPermission:manage-tham-vieng-ban-nganh-thanh-trang')
                    ->defaults('banType', 'thanh_trang')
                    ->name('filter_de_xuat_tham_vieng');
                Route::get('/filter-tham-vieng', [BanNganhController::class, 'filterThamVieng'])
                    ->middleware('checkPermission:manage-tham-vieng-ban-nganh-thanh-trang')
                    ->defaults('banType', 'thanh_trang')
                    ->name('filter_tham_vieng');

                // Task Assignment
                Route::post('/phan-cong-nhiem-vu', [BanNganhController::class, 'phanCongNhiemVu'])
                    ->middleware('checkPermission:manage-phan-cong-ban-nganh-thanh-trang')
                    ->defaults('banType', 'thanh_trang')
                    ->name('phan_cong_nhiem_vu');
                Route::delete('/xoa-phan-cong/{id}', [BanNganhController::class, 'xoaPhanCong'])
                    ->middleware('checkPermission:manage-phan-cong-ban-nganh-thanh-trang')
                    ->defaults('banType', 'thanh_trang')
                    ->name('xoa_phan_cong');

                // Reports and Statistics
                Route::post('/luu-bao-cao', [BanNganhController::class, 'luuBaoCao'])
                    ->middleware('checkPermission:manage-bao-cao-ban-nganh-thanh-trang')
                    ->defaults('banType', 'thanh_trang')
                    ->name('luu_bao_cao');
                Route::post('/update-tham-du', [BanNganhController::class, 'updateThamDu'])
                    ->middleware('checkPermission:manage-bao-cao-ban-nganh-thanh-trang')
                    ->defaults('banType', 'thanh_trang')
                    ->name('update_tham_du');
                Route::delete('/xoa-danh-gia/{id}', [BanNganhController::class, 'xoaDanhGia'])
                    ->middleware('checkPermission:manage-bao-cao-ban-nganh-thanh-trang')
                    ->defaults('banType', 'thanh_trang')
                    ->name('xoa_danh_gia');
                Route::delete('/xoa-kien-nghi/{id}', [BanNganhController::class, 'xoaKienNghi'])
                    ->middleware('checkPermission:manage-bao-cao-ban-nganh-thanh-trang')
                    ->defaults('banType', 'thanh_trang')
                    ->name('xoa_kien_nghi');
            });

        // Web Routes for management interface
        Route::name('_ban_nganh.thanh_trang.')
            ->group(function () {
                Route::get('/', [BanNganhController::class, 'index'])
                    ->middleware('checkPermission:view-ban-nganh-thanh-trang')
                    ->defaults('banType', 'thanh_trang')
                    ->name('index');
                Route::get('/diem-danh', [BanNganhController::class, 'diemDanh'])
                    ->middleware('checkPermission:diem-danh-ban-nganh-thanh-trang')
                    ->defaults('banType', 'thanh_trang')
                    ->name('diem_danh');
                Route::get('/tham-vieng', [BanNganhController::class, 'thamVieng'])
                    ->middleware('checkPermission:tham-vieng-ban-nganh-thanh-trang')
                    ->defaults('banType', 'thanh_trang')
                    ->name('tham_vieng');
                Route::get('/phan-cong', [BanNganhController::class, 'phanCong'])
                    ->middleware('checkPermission:phan-cong-ban-nganh-thanh-trang')
                    ->defaults('banType', 'thanh_trang')
                    ->name('phan_cong');
                Route::get('/phan-cong-chi-tiet', [BanNganhController::class, 'phanCongChiTiet'])
                    ->middleware('checkPermission:phan-cong-chi-tiet-ban-nganh-thanh-trang')
                    ->defaults('banType', 'thanh_trang')
                    ->name('phan_cong_chi_tiet');
                Route::get('/nhap-lieu-bao-cao', [BanNganhController::class, 'formBaoCaoBan'])
                    ->middleware('checkPermission:nhap-lieu-bao-cao-ban-nganh-thanh-trang')
                    ->defaults('banType', 'thanh_trang')
                    ->name('nhap_lieu_bao_cao');
                Route::get('/bao-cao', [BanNganhController::class, 'baoCaoBan'])
                    ->middleware('checkPermission:bao-cao-ban-nganh-thanh-trang')
                    ->defaults('banType', 'thanh_trang')
                    ->name('bao_cao');

                // Data Saving Routes
                Route::post('/save-tham-du', [BanNganhController::class, 'saveThamDu'])
                    ->middleware('checkPermission:manage-bao-cao-ban-nganh-thanh-trang')
                    ->defaults('banType', 'thanh_trang')
                    ->name('save_tham_du');
                Route::post('/save-danh-gia', [BanNganhController::class, 'saveDanhGia'])
                    ->middleware('checkPermission:manage-bao-cao-ban-nganh-thanh-trang')
                    ->defaults('banType', 'thanh_trang')
                    ->name('save_danh_gia');
                Route::post('/save-ke-hoach', [BanNganhController::class, 'saveKeHoach'])
                    ->middleware('checkPermission:manage-bao-cao-ban-nganh-thanh-trang')
                    ->defaults('banType', 'thanh_trang')
                    ->name('save_ke_hoach');
                Route::post('/save-kien-nghi', [BanNganhController::class, 'saveKienNghi'])
                    ->middleware('checkPermission:manage-bao-cao-ban-nganh-thanh-trang')
                    ->defaults('banType', 'thanh_trang')
                    ->name('save_kien_nghi');
            });
    });

// Ban Thanh Niên Routes
Route::prefix('ban-nganh/ban-thanh-nien')
    ->middleware(['auth'])
    ->group(function () {
        // API Routes for data operations
        Route::prefix('api')
            ->name('api.ban_nganh.thanh_nien.')
            ->group(function () {
                // Member Management
                Route::post('/them-thanh-vien', [BanNganhController::class, 'themThanhVien'])
                    ->middleware('checkPermission:manage-thanh-vien-ban-nganh-thanh-nien')
                    ->defaults('banType', 'thanh_nien')
                    ->name('them_thanh_vien');
                Route::delete('/xoa-thanh-vien', [BanNganhController::class, 'xoaThanhVien'])
                    ->middleware('checkPermission:manage-thanh-vien-ban-nganh-thanh-nien')
                    ->defaults('banType', 'thanh_nien')
                    ->name('xoa_thanh_vien');
                Route::put('/cap-nhat-chuc-vu', [BanNganhController::class, 'capNhatChucVu'])
                    ->middleware('checkPermission:manage-thanh-vien-ban-nganh-thanh-nien')
                    ->defaults('banType', 'thanh_nien')
                    ->name('cap_nhat_chuc_vu');
                Route::get('/chi-tiet-thanh-vien', [BanNganhController::class, 'chiTietThanhVien'])
                    ->middleware('checkPermission:view-thanh-vien-ban-nganh-thanh-nien')
                    ->defaults('banType', 'thanh_nien')
                    ->name('chi_tiet_thanh_vien');

                // Member Lists
                Route::get('/dieu-hanh-list', [BanNganhController::class, 'dieuHanhList'])
                    ->middleware('checkPermission:view-thanh-vien-ban-nganh-thanh-nien')
                    ->defaults('banType', 'thanh_nien')
                    ->name('dieu_hanh_list');
                Route::get('/ban-vien-list', [BanNganhController::class, 'banVienList'])
                    ->middleware('checkPermission:view-thanh-vien-ban-nganh-thanh-nien')
                    ->defaults('banType', 'thanh_nien')
                    ->name('ban_vien_list');

                // Meeting Management
                Route::post('/buoi-nhom', [BanNganhController::class, 'themBuoiNhom'])
                    ->middleware('checkPermission:manage-buoi-nhom-ban-nganh-thanh-nien')
                    ->defaults('banType', 'thanh_nien')
                    ->name('them_buoi_nhom');
                Route::put('/buoi-nhom/{buoiNhom}', [BanNganhController::class, 'updateBuoiNhom'])
                    ->middleware('checkPermission:manage-buoi-nhom-ban-nganh-thanh-nien')
                    ->defaults('banType', 'thanh_nien')
                    ->name('update_buoi_nhom');
                Route::delete('/buoi-nhom/{buoiNhom}', [BanNganhController::class, 'deleteBuoiNhom'])
                    ->middleware('checkPermission:manage-buoi-nhom-ban-nganh-thanh-nien')
                    ->defaults('banType', 'thanh_nien')
                    ->name('delete_buoi_nhom');
                Route::post('/luu-diem-danh', [BanNganhController::class, 'luuDiemDanh'])
                    ->middleware('checkPermission:manage-buoi-nhom-ban-nganh-thanh-nien')
                    ->defaults('banType', 'thanh_nien')
                    ->name('luu_diem_danh');

                // Visitation Management
                Route::post('/them-tham-vieng', [BanNganhController::class, 'themThamVieng'])
                    ->middleware('checkPermission:manage-tham-vieng-ban-nganh-thanh-nien')
                    ->defaults('banType', 'thanh_nien')
                    ->name('them_tham_vieng');
                Route::put('/tham-vieng/{id}', [BanNganhController::class, 'updateThamVieng'])
                    ->middleware('checkPermission:manage-tham-vieng-ban-nganh-thanh-nien')
                    ->defaults('banType', 'thanh_nien')
                    ->name('update_tham_vieng');
                Route::get('/chi-tiet-tham-vieng/{id}', [BanNganhController::class, 'chiTietThamVieng'])
                    ->middleware('checkPermission:manage-tham-vieng-ban-nganh-thanh-nien')
                    ->defaults('banType', 'thanh_nien')
                    ->name('chi_tiet_tham_vieng');
                Route::get('/filter-de-xuat-tham-vieng', [BanNganhController::class, 'filterDeXuatThamVieng'])
                    ->middleware('checkPermission:manage-tham-vieng-ban-nganh-thanh-nien')
                    ->defaults('banType', 'thanh_nien')
                    ->name('filter_de_xuat_tham_vieng');
                Route::get('/filter-tham-vieng', [BanNganhController::class, 'filterThamVieng'])
                    ->middleware('checkPermission:manage-tham-vieng-ban-nganh-thanh-nien')
                    ->defaults('banType', 'thanh_nien')
                    ->name('filter_tham_vieng');

                // Task Assignment
                Route::post('/phan-cong-nhiem-vu', [BanNganhController::class, 'phanCongNhiemVu'])
                    ->middleware('checkPermission:manage-phan-cong-ban-nganh-thanh-nien')
                    ->defaults('banType', 'thanh_nien')
                    ->name('phan_cong_nhiem_vu');
                Route::delete('/xoa-phan-cong/{id}', [BanNganhController::class, 'xoaPhanCong'])
                    ->middleware('checkPermission:manage-phan-cong-ban-nganh-thanh-nien')
                    ->defaults('banType', 'thanh_nien')
                    ->name('xoa_phan_cong');

                // Reports and Statistics
                Route::post('/luu-bao-cao', [BanNganhController::class, 'luuBaoCao'])
                    ->middleware('checkPermission:manage-bao-cao-ban-nganh-thanh-nien')
                    ->defaults('banType', 'thanh_nien')
                    ->name('luu_bao_cao');
                Route::post('/update-tham-du', [BanNganhController::class, 'updateThamDu'])
                    ->middleware('checkPermission:manage-bao-cao-ban-nganh-thanh-nien')
                    ->defaults('banType', 'thanh_nien')
                    ->name('update_tham_du');
                Route::delete('/xoa-danh-gia/{id}', [BanNganhController::class, 'xoaDanhGia'])
                    ->middleware('checkPermission:manage-bao-cao-ban-nganh-thanh-nien')
                    ->defaults('banType', 'thanh_nien')
                    ->name('xoa_danh_gia');
                Route::delete('/xoa-kien-nghi/{id}', [BanNganhController::class, 'xoaKienNghi'])
                    ->middleware('checkPermission:manage-bao-cao-ban-nganh-thanh-nien')
                    ->defaults('banType', 'thanh_nien')
                    ->name('xoa_kien_nghi');
            });

        // Web Routes for management interface
        Route::name('_ban_nganh.thanh_nien.')
            ->group(function () {
                Route::get('/', [BanNganhController::class, 'index'])
                    ->middleware('checkPermission:view-ban-nganh-thanh-nien')
                    ->defaults('banType', 'thanh_nien')
                    ->name('index');
                Route::get('/diem-danh', [BanNganhController::class, 'diemDanh'])
                    ->middleware('checkPermission:diem-danh-ban-nganh-thanh-nien')
                    ->defaults('banType', 'thanh_nien')
                    ->name('diem_danh');
                Route::get('/tham-vieng', [BanNganhController::class, 'thamVieng'])
                    ->middleware('checkPermission:tham-vieng-ban-nganh-thanh-nien')
                    ->defaults('banType', 'thanh_nien')
                    ->name('tham_vieng');
                Route::get('/phan-cong', [BanNganhController::class, 'phanCong'])
                    ->middleware('checkPermission:phan-cong-ban-nganh-thanh-nien')
                    ->defaults('banType', 'thanh_nien')
                    ->name('phan_cong');
                Route::get('/phan-cong-chi-tiet', [BanNganhController::class, 'phanCongChiTiet'])
                    ->middleware('checkPermission:phan-cong-chi-tiet-ban-nganh-thanh-nien')
                    ->defaults('banType', 'thanh_nien')
                    ->name('phan_cong_chi_tiet');
                Route::get('/nhap-lieu-bao-cao', [BanNganhController::class, 'formBaoCaoBan'])
                    ->middleware('checkPermission:nhap-lieu-bao-cao-ban-nganh-thanh-nien')
                    ->defaults('banType', 'thanh_nien')
                    ->name('nhap_lieu_bao_cao');
                Route::get('/bao-cao', [BanNganhController::class, 'baoCaoBan'])
                    ->middleware('checkPermission:bao-cao-ban-nganh-thanh-nien')
                    ->defaults('banType', 'thanh_nien')
                    ->name('bao_cao');

                // Data Saving Routes
                Route::post('/save-tham-du', [BanNganhController::class, 'saveThamDu'])
                    ->middleware('checkPermission:manage-bao-cao-ban-nganh-thanh-nien')
                    ->defaults('banType', 'thanh_nien')
                    ->name('save_tham_du');
                Route::post('/save-danh-gia', [BanNganhController::class, 'saveDanhGia'])
                    ->middleware('checkPermission:manage-bao-cao-ban-nganh-thanh-nien')
                    ->defaults('banType', 'thanh_nien')
                    ->name('save_danh_gia');
                Route::post('/save-ke-hoach', [BanNganhController::class, 'saveKeHoach'])
                    ->middleware('checkPermission:manage-bao-cao-ban-nganh-thanh-nien')
                    ->defaults('banType', 'thanh_nien')
                    ->name('save_ke_hoach');
                Route::post('/save-kien-nghi', [BanNganhController::class, 'saveKienNghi'])
                    ->middleware('checkPermission:manage-bao-cao-ban-nganh-thanh-nien')
                    ->defaults('banType', 'thanh_nien')
                    ->name('save_kien_nghi');
            });
    });

// Ban Thiếu Nhi Routes
Route::prefix('ban-nganh/ban-thieu-nhi')
    ->middleware(['auth'])
    ->group(function () {
        // API Routes for data operations
        Route::prefix('api')
            ->name('api.ban_nganh.thieu_nhi.')
            ->group(function () {
                // Member Management
                Route::post('/them-thanh-vien', [BanNganhController::class, 'themThanhVien'])
                    ->middleware('checkPermission:manage-thanh-vien-ban-nganh-thieu-nhi')
                    ->defaults('banType', 'thieu_nhi')
                    ->name('them_thanh_vien');
                Route::delete('/xoa-thanh-vien', [BanNganhController::class, 'xoaThanhVien'])
                    ->middleware('checkPermission:manage-thanh-vien-ban-nganh-thieu-nhi')
                    ->defaults('banType', 'thieu_nhi')
                    ->name('xoa_thanh_vien');
                Route::put('/cap-nhat-chuc-vu', [BanNganhController::class, 'capNhatChucVu'])
                    ->middleware('checkPermission:manage-thanh-vien-ban-nganh-thieu-nhi')
                    ->defaults('banType', 'thieu_nhi')
                    ->name('cap_nhat_chuc_vu');
                Route::get('/chi-tiet-thanh-vien', [BanNganhController::class, 'chiTietThanhVien'])
                    ->middleware('checkPermission:view-thanh-vien-ban-nganh-thieu-nhi')
                    ->defaults('banType', 'thieu_nhi')
                    ->name('chi_tiet_thanh_vien');

                // Member Lists
                Route::get('/dieu-hanh-list', [BanNganhController::class, 'dieuHanhList'])
                    ->middleware('checkPermission:view-thanh-vien-ban-nganh-thieu-nhi')
                    ->defaults('banType', 'thieu_nhi')
                    ->name('dieu_hanh_list');
                Route::get('/ban-vien-list', [BanNganhController::class, 'banVienList'])
                    ->middleware('checkPermission:view-thanh-vien-ban-nganh-thieu-nhi')
                    ->defaults('banType', 'thieu_nhi')
                    ->name('ban_vien_list');

                // Meeting Management
                Route::post('/buoi-nhom', [BanNganhController::class, 'themBuoiNhom'])
                    ->middleware('checkPermission:manage-buoi-nhom-ban-nganh-thieu-nhi')
                    ->defaults('banType', 'thieu_nhi')
                    ->name('them_buoi_nhom');
                Route::put('/buoi-nhom/{buoiNhom}', [BanNganhController::class, 'updateBuoiNhom'])
                    ->middleware('checkPermission:manage-buoi-nhom-ban-nganh-thieu-nhi')
                    ->defaults('banType', 'thieu_nhi')
                    ->name('update_buoi_nhom');
                Route::delete('/buoi-nhom/{buoiNhom}', [BanNganhController::class, 'deleteBuoiNhom'])
                    ->middleware('checkPermission:manage-buoi-nhom-ban-nganh-thieu-nhi')
                    ->defaults('banType', 'thieu_nhi')
                    ->name('delete_buoi_nhom');
                Route::post('/luu-diem-danh', [BanNganhController::class, 'luuDiemDanh'])
                    ->middleware('checkPermission:manage-buoi-nhom-ban-nganh-thieu-nhi')
                    ->defaults('banType', 'thieu_nhi')
                    ->name('luu_diem_danh');

                // Visitation Management
                Route::post('/them-tham-vieng', [BanNganhController::class, 'themThamVieng'])
                    ->middleware('checkPermission:manage-tham-vieng-ban-nganh-thieu-nhi')
                    ->defaults('banType', 'thieu_nhi')
                    ->name('them_tham_vieng');
                Route::put('/tham-vieng/{id}', [BanNganhController::class, 'updateThamVieng'])
                    ->middleware('checkPermission:manage-tham-vieng-ban-nganh-thieu-nhi')
                    ->defaults('banType', 'thieu_nhi')
                    ->name('update_tham_vieng');
                Route::get('/chi-tiet-tham-vieng/{id}', [BanNganhController::class, 'chiTietThamVieng'])
                    ->middleware('checkPermission:manage-tham-vieng-ban-nganh-thieu-nhi')
                    ->defaults('banType', 'thieu_nhi')
                    ->name('chi_tiet_tham_vieng');
                Route::get('/filter-de-xuat-tham-vieng', [BanNganhController::class, 'filterDeXuatThamVieng'])
                    ->middleware('checkPermission:manage-tham-vieng-ban-nganh-thieu-nhi')
                    ->defaults('banType', 'thieu_nhi')
                    ->name('filter_de_xuat_tham_vieng');
                Route::get('/filter-tham-vieng', [BanNganhController::class, 'filterThamVieng'])
                    ->middleware('checkPermission:manage-tham-vieng-ban-nganh-thieu-nhi')
                    ->defaults('banType', 'thieu_nhi')
                    ->name('filter_tham_vieng');

                // Task Assignment
                Route::post('/phan-cong-nhiem-vu', [BanNganhController::class, 'phanCongNhiemVu'])
                    ->middleware('checkPermission:manage-phan-cong-ban-nganh-thieu-nhi')
                    ->defaults('banType', 'thieu_nhi')
                    ->name('phan_cong_nhiem_vu');
                Route::delete('/xoa-phan-cong/{id}', [BanNganhController::class, 'xoaPhanCong'])
                    ->middleware('checkPermission:manage-phan-cong-ban-nganh-thieu-nhi')
                    ->defaults('banType', 'thieu_nhi')
                    ->name('xoa_phan_cong');

                // Reports and Statistics
                Route::post('/luu-bao-cao', [BanNganhController::class, 'luuBaoCao'])
                    ->middleware('checkPermission:manage-bao-cao-ban-nganh-thieu-nhi')
                    ->defaults('banType', 'thieu_nhi')
                    ->name('luu_bao_cao');
                Route::post('/update-tham-du', [BanNganhController::class, 'updateThamDu'])
                    ->middleware('checkPermission:manage-bao-cao-ban-nganh-thieu-nhi')
                    ->defaults('banType', 'thieu_nhi')
                    ->name('update_tham_du');
                Route::delete('/xoa-danh-gia/{id}', [BanNganhController::class, 'xoaDanhGia'])
                    ->middleware('checkPermission:manage-bao-cao-ban-nganh-thieu-nhi')
                    ->defaults('banType', 'thieu_nhi')
                    ->name('xoa_danh_gia');
                Route::delete('/xoa-kien-nghi/{id}', [BanNganhController::class, 'xoaKienNghi'])
                    ->middleware('checkPermission:manage-bao-cao-ban-nganh-thieu-nhi')
                    ->defaults('banType', 'thieu_nhi')
                    ->name('xoa_kien_nghi');
            });

        // Web Routes for management interface
        Route::name('_ban_nganh.thieu_nhi.')
            ->group(function () {
                Route::get('/', [BanNganhController::class, 'index'])
                    ->middleware('checkPermission:view-ban-nganh-thieu-nhi')
                    ->defaults('banType', 'thieu_nhi')
                    ->name('index');
                Route::get('/diem-danh', [BanNganhController::class, 'diemDanh'])
                    ->middleware('checkPermission:diem-danh-ban-nganh-thieu-nhi')
                    ->defaults('banType', 'thieu_nhi')
                    ->name('diem_danh');
                Route::get('/tham-vieng', [BanNganhController::class, 'thamVieng'])
                    ->middleware('checkPermission:tham-vieng-ban-nganh-thieu-nhi')
                    ->defaults('banType', 'thieu_nhi')
                    ->name('tham_vieng');
                Route::get('/phan-cong', [BanNganhController::class, 'phanCong'])
                    ->middleware('checkPermission:phan-cong-ban-nganh-thieu-nhi')
                    ->defaults('banType', 'thieu_nhi')
                    ->name('phan_cong');
                Route::get('/phan-cong-chi-tiet', [BanNganhController::class, 'phanCongChiTiet'])
                    ->middleware('checkPermission:phan-cong-chi-tiet-ban-nganh-thieu-nhi')
                    ->defaults('banType', 'thieu_nhi')
                    ->name('phan_cong_chi_tiet');
                Route::get('/nhap-lieu-bao-cao', [BanNganhController::class, 'formBaoCaoBan'])
                    ->middleware('checkPermission:nhap-lieu-bao-cao-ban-nganh-thieu-nhi')
                    ->defaults('banType', 'thieu_nhi')
                    ->name('nhap_lieu_bao_cao');
                Route::get('/bao-cao', [BanNganhController::class, 'baoCaoBan'])
                    ->middleware('checkPermission:bao-cao-ban-nganh-thieu-nhi')
                    ->defaults('banType', 'thieu_nhi')
                    ->name('bao_cao');

                // Data Saving Routes
                Route::post('/save-tham-du', [BanNganhController::class, 'saveThamDu'])
                    ->middleware('checkPermission:manage-bao-cao-ban-nganh-thieu-nhi')
                    ->defaults('banType', 'thieu_nhi')
                    ->name('save_tham_du');
                Route::post('/save-danh-gia', [BanNganhController::class, 'saveDanhGia'])
                    ->middleware('checkPermission:manage-bao-cao-ban-nganh-thieu-nhi')
                    ->defaults('banType', 'thieu_nhi')
                    ->name('save_danh_gia');
                Route::post('/save-ke-hoach', [BanNganhController::class, 'saveKeHoach'])
                    ->middleware('checkPermission:manage-bao-cao-ban-nganh-thieu-nhi')
                    ->defaults('banType', 'thieu_nhi')
                    ->name('save_ke_hoach');
                Route::post('/save-kien-nghi', [BanNganhController::class, 'saveKienNghi'])
                    ->middleware('checkPermission:manage-bao-cao-ban-nganh-thieu-nhi')
                    ->defaults('banType', 'thieu_nhi')
                    ->name('save_kien_nghi');
            });
    });
