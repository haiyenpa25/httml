<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * @var string
     */
    public const HOME = '/trang-chu'; // Đổi thành đường dẫn trang chủ của bạn

    /**
     * Define your route model bindings, pattern filters, etc.
     */
    public function boot(): void
    {
        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });

        // Đăng ký tất cả middleware cần thiết
        // Đăng ký các middleware cần thiết
        $this->app->router->aliasMiddleware('auth', \Illuminate\Auth\Middleware\Authenticate::class);
        $this->app->router->aliasMiddleware('checkRole', \App\Http\Middleware\CheckRole::class);
    }

    /**
     * Define the "web" routes for the application.
     */
    protected function mapWebRoutes(): void
    {
        Route::middleware('web')
            ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     */
    protected function mapApiRoutes(): void
    {
        Route::prefix('api')
            ->middleware('api')
            ->group(base_path('routes/api.php'));
    }
}
