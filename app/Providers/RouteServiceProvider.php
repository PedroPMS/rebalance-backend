<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public const HOME = '/home';

    protected $namespace = 'App\\Http\\Controllers';
    protected string $namespaceAuth = 'App\\Http\\Controllers\\Auth';
    protected string $namespaceWallet = 'App\\Http\\Controllers\\Wallet';

    public function boot()
    {
        $this->configureRateLimiting();
        $this->loadRouteFiles();
        $this->paramTypesConstraints();
    }

    private function loadRouteFiles()
    {
        $this->routes(
            function () {
                Route::namespace($this->namespaceAuth)->group(base_path('routes/auth.php'));
                Route::namespace($this->namespace)->middleware('web')->group(base_path('routes/web.php'));
                Route::namespace($this->namespaceWallet)->group(base_path('routes/wallet.php'));
            }
        );
    }

    private function paramTypesConstraints()
    {
        $integerParams = [
            'auth',
            'wallet',
        ];
        foreach ($integerParams as $param) {
            Route::pattern($param, '[0-9]+');
        }
    }

    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }
}
