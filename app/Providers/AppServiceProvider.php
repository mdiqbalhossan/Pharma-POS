<?php
namespace App\Providers;

use App\Models\Setting;
use App\View\Components\AuthLayout;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
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

        if (Schema::hasTable('settings')) {
            $settings = Setting::first();
            if ($settings) {
                config(['app.name' => $settings->company_name]);
            }
        }

        if (session()->has('language')) {
            App::setLocale(session('language'));
        }
    }
}
