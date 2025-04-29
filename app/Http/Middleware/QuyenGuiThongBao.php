<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class QuyenGuiThongBao
{
    /**
     * Kiểm tra quyền gửi thông báo.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->guest()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['error' => 'Unauthorized.'], 401);
            }

            return redirect()->route('login');
        }

        $user = Auth::user();

        // Kiểm tra quyền gửi thông báo dựa trên vai trò
        if (!$this->canSendNotification($user, $request)) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['error' => 'Không có quyền gửi thông báo.'], 403);
            }

            return redirect()->route('thong-bao.index')
                ->with('error', 'Bạn không có quyền gửi thông báo.');
        }

        return $next($request);
    }

    /**
     * Kiểm tra xem người dùng có quyền gửi thông báo không.
     *
     * @param  \App\Models\NguoiDung  $user
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    private function canSendNotification($user, $request)
    {
        // Quản trị viên luôn có quyền gửi thông báo
        if ($user->vai_tro === 'quan_tri') {
            return true;
        }

        // Trưởng ban có thể gửi thông báo cho thành viên trong ban ngành của mình
        if ($user->vai_tro === 'truong_ban') {
            // Nếu đang gửi thông báo, kiểm tra người nhận
            if ($request->isMethod('post') && $request->has('nguoi_nhan')) {
                // Logic kiểm tra sẽ được xử lý trong controller
                return true;
            }

            // Cho phép truy cập form gửi thông báo
            return true;
        }

        // Thành viên thường chỉ có thể gửi thông báo cá nhân cho trưởng ban hoặc quản trị viên
        if ($user->vai_tro === 'thanh_vien') {
            // Nếu đang gửi thông báo, kiểm tra người nhận
            if ($request->isMethod('post') && $request->has('nguoi_nhan')) {
                // Logic kiểm tra sẽ được xử lý trong controller
                return true;
            }

            // Cho phép truy cập form gửi thông báo
            return true;
        }

        return false;
    }
}
