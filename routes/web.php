<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BanChapSuController;
use App\Http\Controllers\BanAmThucController;
use App\Http\Controllers\BanCauNguyenController;
use App\Http\Controllers\BanChungDaoController;
use App\Http\Controllers\BanCoDocGiaoDucController;
use App\Http\Controllers\BanDanController;
use App\Http\Controllers\BanHauCanController;
use App\Http\Controllers\BanHatThoPhuongController;
use App\Http\Controllers\BanKhanhTietController;
use App\Http\Controllers\BanKyThuatAmThanhController;
use App\Http\Controllers\BanLeTanController;
use App\Http\Controllers\BanMayChieuController;
use App\Http\Controllers\BanThamViengController;
use App\Http\Controllers\BanTratTuController;
use App\Http\Controllers\BanTruyenGiangController;
use App\Http\Controllers\BanTruyenThongMayChieuController;
use App\Http\Controllers\BanThanhNienController;
use App\Http\Controllers\BanThanhTrangController;
use App\Http\Controllers\BanThieuNhiAuController;
use App\Http\Controllers\BanTrungLaoController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/template', function () {
    return view('template');
});
Route::get('/dashboard', function () {
    return view('dashboard');
});







Route::prefix('quan-ly-ban-nganh')->group(function () {
    Route::resource('ban-chap-su', BanChapSuController::class)->names([
        'index' => 'ban-chap-su.index',
        'create' => 'ban-chap-su.create',
        'store' => 'ban-chap-su.store',
        'show' => 'ban-chap-su.show',
        'edit' => 'ban-chap-su.edit',
        'update' => 'ban-chap-su.update',
        'destroy' => 'ban-chap-su.destroy',
    ]);

    Route::prefix('ban-muc-vu')->group(function () {
        Route::resource('ban-am-thuc', BanAmThucController::class)->names([
            'index' => 'ban-am-thuc.index',
            'create' => 'ban-am-thuc.create',
            'store' => 'ban-am-thuc.store',
            'show' => 'ban-am-thuc.show',
            'edit' => 'ban-am-thuc.edit',
            'update' => 'ban-am-thuc.update',
            'destroy' => 'ban-am-thuc.destroy',
        ]);
        Route::resource('ban-cau-nguyen', BanCauNguyenController::class)->names([
            'index' => 'ban-cau-nguyen.index',
            'create' => 'ban-cau-nguyen.create',
            'store' => 'ban-cau-nguyen.store',
            'show' => 'ban-cau-nguyen.show',
            'edit' => 'ban-cau-nguyen.edit',
            'update' => 'ban-cau-nguyen.update',
            'destroy' => 'ban-cau-nguyen.destroy',
        ]);
        Route::resource('ban-chung-dao', BanChungDaoController::class)->names([
            'index' => 'ban-chung-dao.index',
            'create' => 'ban-chung-dao.create',
            'store' => 'ban-chung-dao.store',
            'show' => 'ban-chung-dao.show',
            'edit' => 'ban-chung-dao.edit',
            'update' => 'ban-chung-dao.update',
            'destroy' => 'ban-chung-dao.destroy',
        ]);
        Route::resource('ban-co-doc-giao-duc', BanCoDocGiaoDucController::class)->names([
            'index' => 'ban-co-doc-giao-duc.index',
            'create' => 'ban-co-doc-giao-duc.create',
            'store' => 'ban-co-doc-giao-duc.store',
            'show' => 'ban-co-doc-giao-duc.show',
            'edit' => 'ban-co-doc-giao-duc.edit',
            'update' => 'ban-co-doc-giao-duc.update',
            'destroy' => 'ban-co-doc-giao-duc.destroy',
        ]);
        Route::resource('ban-dan', BanDanController::class)->names([
            'index' => 'ban-dan.index',
            'create' => 'ban-dan.create',
            'store' => 'ban-dan.store',
            'show' => 'ban-dan.show',
            'edit' => 'ban-dan.edit',
            'update' => 'ban-dan.update',
            'destroy' => 'ban-dan.destroy',
        ]);
        Route::resource('ban-hau-can', BanHauCanController::class)->names([
            'index' => 'ban-hau-can.index',
            'create' => 'ban-hau-can.create',
            'store' => 'ban-hau-can.store',
            'show' => 'ban-hau-can.show',
            'edit' => 'ban-hau-can.edit',
            'update' => 'ban-hau-can.update',
            'destroy' => 'ban-hau-can.destroy',
        ]);
        Route::resource('ban-hat-tho-phuong', BanHatThoPhuongController::class)->names([
            'index' => 'ban-hat-tho-phuong.index',
            'create' => 'ban-hat-tho-phuong.create',
            'store' => 'ban-hat-tho-phuong.store',
            'show' => 'ban-hat-tho-phuong.show',
            'edit' => 'ban-hat-tho-phuong.edit',
            'update' => 'ban-hat-tho-phuong.update',
            'destroy' => 'ban-hat-tho-phuong.destroy',
        ]);
        Route::resource('ban-khanh-tiet', BanKhanhTietController::class)->names([
            'index' => 'ban-khanh-tiet.index',
            'create' => 'ban-khanh-tiet.create',
            'store' => 'ban-khanh-tiet.store',
            'show' => 'ban-khanh-tiet.show',
            'edit' => 'ban-khanh-tiet.edit',
            'update' => 'ban-khanh-tiet.update',
            'destroy' => 'ban-khanh-tiet.destroy',
        ]);
        Route::resource('ban-ky-thuat-am-thanh', BanKyThuatAmThanhController::class)->names([
            'index' => 'ban-ky-thuat-am-thanh.index',
            'create' => 'ban-ky-thuat-am-thanh.create',
            'store' => 'ban-ky-thuat-am-thanh.store',
            'show' => 'ban-ky-thuat-am-thanh.show',
            'edit' => 'ban-ky-thuat-am-thanh.edit',
            'update' => 'ban-ky-thuat-am-thanh.update',
            'destroy' => 'ban-ky-thuat-am-thanh.destroy',
        ]);
        Route::resource('ban-le-tan', BanLeTanController::class)->names([
            'index' => 'ban-le-tan.index',
            'create' => 'ban-le-tan.create',
            'store' => 'ban-le-tan.store',
            'show' => 'ban-le-tan.show',
            'edit' => 'ban-le-tan.edit',
            'update' => 'ban-le-tan.update',
            'destroy' => 'ban-le-tan.destroy',
        ]);
        Route::resource('ban-may-chieu', BanMayChieuController::class)->names([
            'index' => 'ban-may-chieu.index',
            'create' => 'ban-may-chieu.create',
            'store' => 'ban-may-chieu.store',
            'show' => 'ban-may-chieu.show',
            'edit' => 'ban-may-chieu.edit',
            'update' => 'ban-may-chieu.update',
            'destroy' => 'ban-may-chieu.destroy',
        ]);
        Route::resource('ban-tham-vieng', BanThamViengController::class)->names([
            'index' => 'ban-tham-vieng.index',
            'create' => 'ban-tham-vieng.create',
            'store' => 'ban-tham-vieng.store',
            'show' => 'ban-tham-vieng.show',
            'edit' => 'ban-tham-vieng.edit',
            'update' => 'ban-tham-vieng.update',
            'destroy' => 'ban-tham-vieng.destroy',
        ]);
        Route::resource('ban-trat-tu', BanTratTuController::class)->names([
            'index' => 'ban-trat-tu.index',
            'create' => 'ban-trat-tu.create',
            'store' => 'ban-trat-tu.store',
            'show' => 'ban-trat-tu.show',
            'edit' => 'ban-trat-tu.edit',
            'update' => 'ban-trat-tu.update',
            'destroy' => 'ban-trat-tu.destroy',
        ]);
        Route::resource('ban-truyen-giang', BanTruyenGiangController::class)->names([
            'index' => 'ban-truyen-giang.index',
            'create' => 'ban-truyen-giang.create',
            'store' => 'ban-truyen-giang.store',
            'show' => 'ban-truyen-giang.show',
            'edit' => 'ban-truyen-giang.edit',
            'update' => 'ban-truyen-giang.update',
            'destroy' => 'ban-truyen-giang.destroy',
        ]);
        Route::resource('ban-truyen-thong-may-chieu', BanTruyenThongMayChieuController::class)->names([
            'index' => 'ban-truyen-thong-may-chieu.index',
            'create' => 'ban-truyen-thong-may-chieu.create',
            'store' => 'ban-truyen-thong-may-chieu.store',
            'show' => 'ban-truyen-thong-may-chieu.show',
            'edit' => 'ban-truyen-thong-may-chieu.edit',
            'update' => 'ban-truyen-thong-may-chieu.update',
            'destroy' => 'ban-truyen-thong-may-chieu.destroy',
        ]);
    });
    Route::prefix('ban-nganh')->group(function () {
        Route::resource('ban-thanh-nien', BanThanhNienController::class)->names([
            'index' => 'ban-thanh-nien.index',
            'create' => 'ban-thanh-nien.create',
            'store' => 'ban-thanh-nien.store',
            'show' => 'ban-thanh-nien.show',
            'edit' => 'ban-thanh-nien.edit',
            'update' => 'ban-thanh-nien.update',
            'destroy' => 'ban-thanh-nien.destroy',
        ]);
        Route::resource('ban-thanh-trang', BanThanhTrangController::class)->names([
            'index' => 'ban-thanh-trang.index',
            'create' => 'ban-thanh-trang.create',
            'store' => 'ban-thanh-trang.store',
            'show' => 'ban-thanh-trang.show',
            'edit' => 'ban-thanh-trang.edit',
            'update' => 'ban-thanh-trang.update',
            'destroy' => 'ban-thanh-trang.destroy',
        ]);
        Route::resource('ban-thieu-nhi-au', BanThieuNhiAuController::class)->names([
            'index' => 'ban-thieu-nhi-au.index',
            'create' => 'ban-thieu-nhi-au.create',
            'store' => 'ban-thieu-nhi-au.store',
            'show' => 'ban-thieu-nhi-au.show',
            'edit' => 'ban-thieu-nhi-au.edit',
            'update' => 'ban-thieu-nhi-au.update',
            'destroy' => 'ban-thieu-nhi-au.destroy',
        ]);
        Route::resource('ban-trung-lao', BanTrungLaoController::class)->names([
            'index' => 'ban-trung-lao.index',
            'create' => 'ban-trung-lao.create',
            'store' => 'ban-trung-lao.store',
            'show' => 'ban-trung-lao.show',
            'edit' => 'ban-trung-lao.edit',
            'update' => 'ban-trung-lao.update',
            'destroy' => 'ban-trung-lao.destroy',
        ]);
    });
});
