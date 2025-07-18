<?php
namespace App\Providers;

use App\View\Components\AuthLayout;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::component('auth-layout', AuthLayout::class);
        if (! $this->app->runningInConsole()) {
            if (! file_exists(base_path('storage/installed')) && ! request()->is('install') && ! request()->is('install/*')) {
                header("Location: install");
                exit;
            }
        }
    }
}
