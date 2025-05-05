<?php

use App\Http\Controllers\BanTrungLaoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController,
    ThongBaoController,
    ThongBao\GuiThongBaoController,
    ThongBao\NhanThongBaoController,
    ThongBao\QuanLyThongBaoController,
    BanMucVuController,
    BanMucVu\BanMucVuThanhVienController
};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Định nghĩa các tuyến đường cho ứng dụng web.
| Các tuyến đường được nhóm theo chức năng và bảo vệ bởi middleware phù hợp.
|
*/

// Nhóm tuyến đường yêu cầu xác thực (đăng nhập)
Route::middleware(['auth'])->group(function () {
    /*
    |--------------------------------------------------------------------------
    | Quản lý thông báo
    |--------------------------------------------------------------------------
    */
    // Trang chủ quản lý thông báo
    Route::get('/thong-bao', [ThongBaoController::class, 'index'])
        ->name('thong-bao.index');

    /*
    |--------------------------------------------------------------------------
    | Hộp thư đến và xem thông báo
    |--------------------------------------------------------------------------
    */
    // Hộp thư đến
    Route::get('/thong-bao/inbox', [ThongBaoController::class, 'inbox'])
        ->name('thong-bao.inbox');

    // Xem chi tiết thông báo
    Route::get('/thong-bao/{id}', [ThongBaoController::class, 'show'])
        ->name('thong-bao.show');

    // Xem thông báo đã lưu trữ
    Route::get('/thong-bao/archived/list', [QuanLyThongBaoController::class, 'archived'])
        ->name('thong-bao.archived');

    // Xem thông báo đã gửi
    Route::get('/thong-bao/sent/list', [QuanLyThongBaoController::class, 'sent'])
        ->name('thong-bao.sent');

    /*
    |--------------------------------------------------------------------------
    | Quản lý trạng thái thông báo
    |--------------------------------------------------------------------------
    */
    // Đánh dấu thông báo đã đọc
    Route::post('/thong-bao/{id}/mark-as-read', [QuanLyThongBaoController::class, 'markAsRead'])
        ->name('thong-bao.mark-as-read');

    // Đánh dấu nhiều thông báo đã đọc
    Route::post('/thong-bao/mark-multiple-as-read', [QuanLyThongBaoController::class, 'markMultipleAsRead'])
        ->name('thong-bao.mark-multiple-as-read');

    // Lưu trữ thông báo
    Route::post('/thong-bao/{id}/archive', [QuanLyThongBaoController::class, 'archive'])
        ->name('thong-bao.archive');

    // Bỏ lưu trữ thông báo
    Route::post('/thong-bao/{id}/unarchive', [QuanLyThongBaoController::class, 'unarchive'])
        ->name('thong-bao.unarchive');

    // Lưu trữ nhiều thông báo
    Route::post('/thong-bao/archive-multiple', [QuanLyThongBaoController::class, 'archiveMultiple'])
        ->name('thong-bao.archive-multiple');

    // Bỏ lưu trữ nhiều thông báo
    Route::post('/thong-bao/unarchive-multiple', [QuanLyThongBaoController::class, 'unarchiveMultiple'])
        ->name('thong-bao.unarchive-multiple');

    /*
    |--------------------------------------------------------------------------
    | Xóa thông báo
    |--------------------------------------------------------------------------
    */
    // Xóa thông báo
    Route::delete('/thong-bao/{id}', [QuanLyThongBaoController::class, 'destroy'])
        ->name('thong-bao.destroy');

    // Xóa nhiều thông báo
    Route::delete('/thong-bao/delete-multiple', [QuanLyThongBaoController::class, 'destroyMultiple'])
        ->name('thong-bao.delete-multiple');

    /*
    |--------------------------------------------------------------------------
    | API thông báo (AJAX)
    |--------------------------------------------------------------------------
    */
    // Đếm thông báo chưa đọc
    Route::get('/thong-bao/count-unread', [ThongBaoController::class, 'countUnread'])
        ->name('thong-bao.count-unread');

    // Lấy thông báo mới nhất
    Route::get('/thong-bao/latest/{limit?}', [ThongBaoController::class, 'getLatestNotifications'])
        ->name('thong-bao.latest');
});

// Nhóm tuyến đường yêu cầu xác thực và quyền gửi thông báo
Route::middleware(['auth', 'checkRole:quan_tri,truong_ban,thanh_vien'])->group(function () {
    /*
    |--------------------------------------------------------------------------
    | Gửi thông báo
    |--------------------------------------------------------------------------
    */
    // Form soạn thông báo mới
    Route::get('/thong-bao/create/new', [ThongBaoController::class, 'create'])
        ->name('thong-bao.create');

    // Lưu thông báo mới
    Route::post('/thong-bao/store', [ThongBaoController::class, 'store'])
        ->name('thong-bao.store');

    // Gửi thông báo nhanh
    Route::post('/thong-bao/quick-message', [GuiThongBaoController::class, 'sendQuickMessage'])
        ->name('thong-bao.quick-message');

    /*
    |--------------------------------------------------------------------------
    | API lấy danh sách người dùng
    |--------------------------------------------------------------------------
    */
    // Lấy danh sách người dùng theo ban ngành
    Route::get('/api/users/ban-nganh/{banNganhId}', [GuiThongBaoController::class, 'getUsersByBanNganh'])
        ->name('api.users.ban-nganh');

    // Lấy trưởng ban của ban ngành
    Route::get('/api/users/truong-ban/{banNganhId}', [GuiThongBaoController::class, 'getTruongBan'])
        ->name('api.users.truong-ban');

    // Lấy danh sách người dùng theo vai trò
    Route::get('/api/users/role/{role}', [GuiThongBaoController::class, 'getUsersByRole'])
        ->name('api.users.role');

    // Lấy danh sách tất cả người dùng
    Route::get('/api/users/all', [GuiThongBaoController::class, 'getAllUsers'])
        ->name('api.users.all');
});
