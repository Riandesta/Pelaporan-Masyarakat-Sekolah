<?php

namespace App\Providers;

use App\Models\Pengaduan;
use App\Observers\PengaduanObserver;
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


    public function boot(): void
    {
        Pengaduan::observe(PengaduanObserver::class);
    }
}
