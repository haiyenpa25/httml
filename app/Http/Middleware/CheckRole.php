<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     * @return \Illuminate\Http\Response
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {

        if (!Auth::check()) {
            return redirect('/login'); // Chưa đăng nhập
        }
        dd(Auth::user()); // Xem thông tin người dùng đang đăng nhập
        dd($roles);      // Xem các vai trò được cho phép
        
        $user = Auth::user();

        if (in_array($user->vai_tro, $roles)) { // Sử dụng $user->vai_tro
            return $next($request); // Có quyền truy cập
        }

        abort(403, 'Bạn không có quyền truy cập trang này.'); // Không có quyền truy cập
    }
}