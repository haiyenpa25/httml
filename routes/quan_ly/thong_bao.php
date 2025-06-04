<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    ThongBaoController,
    ThongBao\GuiThongBaoController,
    ThongBao\QuanLyThongBaoController
};

Route::middleware(['auth'])->group(function () {
    Route::get('/thong-bao', [ThongBaoController::class, 'index'])
        ->middleware('permission:view-thong-bao')
        ->name('thong-bao.index');
    Route::get('/thong-bao/inbox', [ThongBaoController::class, 'inbox'])
        ->middleware('permission:view-thong-bao-inbox')
        ->name('thong-bao.inbox');
    Route::get('/thong-bao/{id}', [ThongBaoController::class, 'show'])
        ->middleware('permission:view-thong-bao-inbox')
        ->name('thong-bao.show');
    Route::get('/thong-bao/archived/list', [QuanLyThongBaoController::class, 'archived'])
        ->middleware('permission:view-thong-bao-archived')
        ->name('thong-bao.archived');
    Route::get('/thong-bao/sent/list', [QuanLyThongBaoController::class, 'sent'])
        ->middleware('permission:view-thong-bao-sent')
        ->name('thong-bao.sent');
    Route::post('/thong-bao/{id}/mark-as-read', [QuanLyThongBaoController::class, 'markAsRead'])
        ->middleware('permission:manage-thong-bao')
        ->name('thong-bao.mark-as-read');
    Route::post('/thong-bao/mark-multiple-as-read', [QuanLyThongBaoController::class, 'markMultipleAsRead'])
        ->middleware('permission:manage-thong-bao')
        ->name('thong-bao.mark-multiple-as-read');
    Route::post('/thong-bao/{id}/archive', [QuanLyThongBaoController::class, 'archive'])
        ->middleware('permission:manage-thong-bao')
        ->name('thong-bao.archive');
    Route::post('/thong-bao/{id}/unarchive', [QuanLyThongBaoController::class, 'unarchive'])
        ->middleware('permission:manage-thong-bao')
        ->name('thong-bao.unarchive');
    Route::post('/thong-bao/archive-multiple', [QuanLyThongBaoController::class, 'archiveMultiple'])
        ->middleware('permission:manage-thong-bao')
        ->name('thong-bao.archive-multiple');
    Route::post('/thong-bao/unarchive-multiple', [QuanLyThongBaoController::class, 'unarchiveMultiple'])
        ->middleware('permission:manage-thong-bao')
        ->name('thong-bao.unarchive-multiple');
    Route::delete('/thong-bao/{id}', [QuanLyThongBaoController::class, 'destroy'])
        ->middleware('permission:delete-thong-bao')
        ->name('thong-bao.destroy');
    Route::delete('/thong-bao/delete-multiple', [QuanLyThongBaoController::class, 'destroyMultiple'])
        ->middleware('permission:delete-thong-bao')
        ->name('thong-bao.delete-multiple');
    Route::get('/thong-bao/count-unread', [ThongBaoController::class, 'countUnread'])
        ->middleware('permission:view-thong-bao')
        ->name('thong-bao.count-unread');
    Route::get('/thong-bao/latest/{limit?}', [ThongBaoController::class, 'getLatestNotifications'])
        ->middleware('permission:view-thong-bao')
        ->name('thong-bao.latest');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/thong-bao/create/new', [ThongBaoController::class, 'create'])
        ->middleware('permission:send-thong-bao')
        ->name('thong-bao.create');
    Route::post('/thong-bao/store', [ThongBaoController::class, 'store'])
        ->middleware('permission:send-thong-bao')
        ->name('thong-bao.store');
    Route::post('/thong-bao/quick-message', [GuiThongBaoController::class, 'sendQuickMessage'])
        ->middleware('permission:send-thong-bao')
        ->name('thong-bao.quick-message');
    Route::get('/api/users/ban-nganh/{banNganhId}', [GuiThongBaoController::class, 'getUsersByBanNganh'])
        ->middleware('permission:send-thong-bao')
        ->name('api.users.ban-nganh');
    Route::get('/api/users/truong-ban/{banNganhId}', [GuiThongBaoController::class, 'getTruongBan'])
        ->middleware('permission:send-thong-bao')
        ->name('api.users.truong-ban');
    Route::get('/api/users/role/{role}', [GuiThongBaoController::class, 'getUsersByRole'])
        ->middleware('permission:send-thong-bao')
        ->name('api.users.role');
    Route::get('/api/users/all', [GuiThongBaoController::class, 'getAllUsers'])
        ->middleware('permission:send-thong-bao')
        ->name('api.users.all');
});
