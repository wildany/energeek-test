<?php

namespace App\Providers;

use App\Repositories\Impl\JobRepositoryImpl;
use App\Repositories\JobRepository;
use App\Services\Impl\JobServiceImpl;
use App\Services\JobService;
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
        $this->app->bind(JobRepository::class, JobRepositoryImpl::class);
        $this->app->bind(JobService::class, JobServiceImpl::class);
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
