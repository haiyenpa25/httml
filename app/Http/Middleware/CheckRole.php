<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class CheckRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();

        foreach ($roles as $role) {
            if ($user->vai_tro == $role) {
                return $next($request);
            }
        }

        Log::warning('User ' . $user->id . ' with vai_tro ' . $user->vai_tro . ' denied access. Required roles: ' . implode(', ', $roles));
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['error' => 'Bạn không có quyền truy cập trang này.'], 403);
        }
        abort(403, 'Bạn không có quyền truy cập trang này.');
    }
}
?>