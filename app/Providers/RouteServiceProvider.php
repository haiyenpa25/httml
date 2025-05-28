<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public const HOME = '/trang-chu';

    public function boot(): void
    {
        // Đăng ký middleware trước khi load routes
        $this->registerMiddleware();

        // Load routes
        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }

    protected function registerMiddleware(): void
    {
        // Đăng ký middleware bằng Route::aliasMiddleware
        Route::aliasMiddleware('auth', \Illuminate\Auth\Middleware\Authenticate::class);
        Route::aliasMiddleware('check.role', \App\Http\Middleware\CheckRole::class);
        Route::aliasMiddleware('check.permission', \App\Http\Middleware\CheckPermission::class);
        Route::aliasMiddleware('quan.tri', \App\Http\Middleware\QuanTri::class);
        Route::aliasMiddleware('quyen.gui.thong.bao', \App\Http\Middleware\QuyenGuiThongBao::class);
    }

    protected function mapWebRoutes(): void
    {
        Route::middleware('web')
            ->group(base_path('routes/web.php'));
    }

    protected function mapApiRoutes(): void
    {
        Route::prefix('api')
            ->middleware('api')
            ->group(base_path('routes/api.php'));
    }
}
