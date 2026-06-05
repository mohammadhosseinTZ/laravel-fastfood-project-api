<?php

namespace App\Providers;

use App\Contracts\Interfaces\AboutusRepository;
use App\Contracts\Interfaces\FeatureRepository;
use App\Contracts\Interfaces\SliderRepository;
use App\Repositories\AboutusRepositoryImp;
use App\Repositories\FeatureRepositoryImp;
use App\Repositories\SliderRepositoryImp;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(SliderRepository::class, SliderRepositoryImp::class);
        $this->app->bind(FeatureRepository::class, FeatureRepositoryImp::class);
        $this->app->bind(AboutusRepository::class, AboutusRepositoryImp::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
