<?php

namespace App\Providers;

use App\Repositories\ChatRepositoryImpl;
use App\Repositories\ChatRepositoryInterface;
use App\Services\ChatServiceImpl;
use App\Services\ChatServiceInterface;
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
        $this->app->bind(ChatRepositoryInterface::class, ChatRepositoryImpl::class);
        $this->app->bind(ChatServiceInterface::class, ChatServiceImpl::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
