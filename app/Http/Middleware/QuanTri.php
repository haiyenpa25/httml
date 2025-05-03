<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuanTri
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để truy cập phân hệ Thủ Quỹ.');
        }

        if (Auth::user()->vai_tro !== 'quan_tri') {
            return redirect()->route('dashboard')->with('error', 'Bạn không có quyền truy cập vào phân hệ Thủ Quỹ. Vui lòng liên hệ quản trị viên.');
        }

        return $next($request);
    }
}