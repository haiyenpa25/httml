<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    ThongBaoController,
    ThongBao\GuiThongBaoController,
    ThongBao\QuanLyThongBaoController
};

// Nhóm tuyến đường yêu cầu xác thực (đăng nhập)
Route::middleware(['auth'])->group(function () {
    // Trang chủ quản lý thông báo
    Route::get('/thong-bao', [ThongBaoController::class, 'index'])
        ->middleware('checkPermission:view-thong-bao')
        ->name('thong-bao.index');

    // Hộp thư đến
    Route::get('/thong-bao/inbox', [ThongBaoController::class, 'inbox'])
        ->middleware('checkPermission:view-thong-bao-inbox')
        ->name('thong-bao.inbox');

    // Xem chi tiết thông báo
    Route::get('/thong-bao/{id}', [ThongBaoController::class, 'show'])
        ->middleware('checkPermission:view-thong-bao-inbox')
        ->name('thong-bao.show');

    // Xem thông báo đã lưu trữ
    Route::get('/thong-bao/archived/list', [QuanLyThongBaoController::class, 'archived'])
        ->middleware('checkPermission:view-thong-bao-archived')
        ->name('thong-bao.archived');

    // Xem thông báo đã gửi
    Route::get('/thong-bao/sent/list', [QuanLyThongBaoController::class, 'sent'])
        ->middleware('checkPermission:view-thong-bao-sent')
        ->name('thong-bao.sent');

    // Đánh dấu thông báo đã đọc
    Route::post('/thong-bao/{id}/mark-as-read', [QuanLyThongBaoController::class, 'markAsRead'])
        ->middleware('checkPermission:manage-thong-bao')
        ->name('thong-bao.mark-as-read');

    // Đánh dấu nhiều thông báo đã đọc
    Route::post('/thong-bao/mark-multiple-as-read', [QuanLyThongBaoController::class, 'markMultipleAsRead'])
        ->middleware('checkPermission:manage-thong-bao')
        ->name('thong-bao.mark-multiple-as-read');

    // Lưu trữ thông báo
    Route::post('/thong-bao/{id}/archive', [QuanLyThongBaoController::class, 'archive'])
        ->middleware('checkPermission:manage-thong-bao')
        ->name('thong-bao.archive');

    // Bỏ lưu trữ thông báo
    Route::post('/thong-bao/{id}/unarchive', [QuanLyThongBaoController::class, 'unarchive'])
        ->middleware('checkPermission:manage-thong-bao')
        ->name('thong-bao.unarchive');

    // Lưu trữ nhiều thông báo
    Route::post('/thong-bao/archive-multiple', [QuanLyThongBaoController::class, 'archiveMultiple'])
        ->middleware('checkPermission:manage-thong-bao')
        ->name('thong-bao.archive-multiple');

    // Bỏ lưu trữ nhiều thông báo
    Route::post('/thong-bao/unarchive-multiple', [QuanLyThongBaoController::class, 'unarchiveMultiple'])
        ->middleware('checkPermission:manage-thong-bao')
        ->name('thong-bao.unarchive-multiple');

    // Xóa thông báo
    Route::delete('/thong-bao/{id}', [QuanLyThongBaoController::class, 'destroy'])
        ->middleware('checkPermission:delete-thong-bao')
        ->name('thong-bao.destroy');

    // Xóa nhiều thông báo
    Route::delete('/thong-bao/delete-multiple', [QuanLyThongBaoController::class, 'destroyMultiple'])
        ->middleware('checkPermission:delete-thong-bao')
        ->name('thong-bao.delete-multiple');

    // Đếm thông báo chưa đọc
    Route::get('/thong-bao/count-unread', [ThongBaoController::class, 'countUnread'])
        ->middleware('checkPermission:view-thong-bao')
        ->name('thong-bao.count-unread');

    // Lấy thông báo mới nhất
    Route::get('/thong-bao/latest/{limit?}', [ThongBaoController::class, 'getLatestNotifications'])
        ->middleware('checkPermission:view-thong-bao')
        ->name('thong-bao.latest');
});

// Nhóm tuyến đường yêu cầu xác thực và quyền gửi thông báo
Route::middleware(['auth'])->group(function () {
    // Form soạn thông báo mới
    Route::get('/thong-bao/create/new', [ThongBaoController::class, 'create'])
        ->middleware('checkPermission:send-thong-bao')
        ->name('thong-bao.create');

    // Lưu thông báo mới
    Route::post('/thong-bao/store', [ThongBaoController::class, 'store'])
        ->middleware('checkPermission:send-thong-bao')
        ->name('thong-bao.store');

    // Gửi thông báo nhanh
    Route::post('/thong-bao/quick-message', [GuiThongBaoController::class, 'sendQuickMessage'])
        ->middleware('checkPermission:send-thong-bao')
        ->name('thong-bao.quick-message');

    // Lấy danh sách người dùng theo ban ngành
    Route::get('/api/users/ban-nganh/{banNganhId}', [GuiThongBaoController::class, 'getUsersByBanNganh'])
        ->middleware('checkPermission:send-thong-bao')
        ->name('api.users.ban-nganh');

    // Lấy trưởng ban của ban ngành
    Route::get('/api/users/truong-ban/{banNganhId}', [GuiThongBaoController::class, 'getTruongBan'])
        ->middleware('checkPermission:send-thong-bao')
        ->name('api.users.truong-ban');

    // Lấy danh sách người dùng theo vai trò
    Route::get('/api/users/role/{role}', [GuiThongBaoController::class, 'getUsersByRole'])
        ->middleware('checkPermission:send-thong-bao')
        ->name('api.users.role');

    // Lấy danh sách tất cả người dùng
    Route::get('/api/users/all', [GuiThongBaoController::class, 'getAllUsers'])
        ->middleware('checkPermission:send-thong-bao')
        ->name('api.users.all');
});
