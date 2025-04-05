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
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect('/login'); // Chưa đăng nhập, chuyển hướng đến trang login
        }

        $user = Auth::user();

        foreach ($roles as $role) {
            if ($user->vai_tro == $role) {
                return $next($request); // Có quyền truy cập
            }
        }

        abort(403, 'Bạn không có quyền truy cập trang này.'); // Không có quyền truy cập
    }
}