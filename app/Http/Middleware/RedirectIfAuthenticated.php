<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::user();
                $defaultUrl = $user->default_url ?? $user->quyen()->whereNotNull('default_url')->value('default_url');
                return redirect($defaultUrl ?? '/dashboard');
            }
        }

        return $next($request);
    }
}
?>