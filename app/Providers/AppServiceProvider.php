<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Models\Siswa;
use App\Observers\SiswaObserver;
use App\Models\Obat;
use App\Observers\ObatObserver;
use App\Models\User;
use App\Observers\UserObserver;
use App\Models\RekamMedis;
use App\Observers\RekamMedisObserver;


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
        Paginator::useBootstrap(); 
        Siswa::observe(SiswaObserver::class);
        Obat::observe(ObatObserver::class);
        User::observe(UserObserver::class);
        RekamMedis::observe(RekamMedisObserver::class);
    }
}
