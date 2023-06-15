<?php

namespace App\Providers;

use App\Models\SiteSetting;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();

        view()->composer(['layouts.customer.index', 'layouts.owner.index', 'customer.landing-page.index', 'customer.about-us'], function ($view) {
            $view->with('settings', Cache::rememberForever('settings', function () {
                return SiteSetting::first();
            }));
        });

        Schema::defaultStringLength(191);
    }
}
