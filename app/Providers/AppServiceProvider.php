<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
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
        //透過內建的【Gate :: define ( )】來定義一 Gate；
        // 此函數接受兩個參數：
        // 1. 自定義的 Gate 名稱
        // 2. callback function；需要從裡面回傳一 boolean 值

        Gate::define('visitAdminPages', function ($user) {
            return $user->isAdmin === 1;
        });

        // 告訴 laravel 分頁的樣式要套用 bootstrap5 的 class
        Paginator::useBootstrapFive();
    }
}
