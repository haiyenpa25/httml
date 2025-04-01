<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$roles
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect('login'); // Hoặc chuyển hướng đến trang đăng nhập
        }

        $user = Auth::user();

        if (empty($roles))
        {
             return $next($request); // Cho phép truy cập nếu không có vai trò nào được chỉ định
        }

        if (in_array($user->vai_tro, $roles)) {
            return $next($request); // Cho phép truy cập nếu người dùng có một trong các vai trò được phép
        }

        // Nếu không có quyền, chuyển hướng hoặc trả về lỗi
        abort(403, 'Bạn không có quyền truy cập trang này.'); // Hoặc chuyển hướng đến trang thông báo lỗi
    }
}
