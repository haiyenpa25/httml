<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::user();
                $defaultUrl = $user->default_url ?? $user->quyen()->whereNotNull('default_url')->value('default_url');

                Log::info('RedirectIfAuthenticated for user ' . $user->id . ': ', [
                    'default_url' => $user->default_url,
                    'permission_default_url' => $user->quyen()->whereNotNull('default_url')->value('default_url'),
                    'final_url' => $defaultUrl ?? '/dashboard'
                ]);

                if ($defaultUrl && !Route::has($defaultUrl)) {
                    Log::warning('Invalid default_url for user ' . $user->id . ': ' . $defaultUrl);
                    $defaultUrl = '/dashboard';
                }

                return redirect($defaultUrl ?? '/dashboard');
            }
        }

        return $next($request);
    }
}
