<?php

namespace App\Providers;

use App\Support\AdminSettings;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
    }

    public function boot(): void
    {
        View::share('appSettings', AdminSettings::all());
    }
}
