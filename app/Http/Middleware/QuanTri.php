<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuanTri
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để truy cập phân hệ Thủ Quỹ.');
        }

        // Thêm PHPDoc để khai báo kiểu trả về
        /** @var \App\Models\NguoiDung $user */
        $user = Auth::user();

        if ($user->vai_tro !== 'quan_tri') {
            return redirect()->route('dashboard')->with('error', 'Bạn không có quyền truy cập vào phân hệ Thủ Quỹ. Vui lòng liên hệ quản trị viên.');
        }

        return $next($request);
    }
}
