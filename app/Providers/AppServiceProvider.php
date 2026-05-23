<?php

namespace App\Providers;

use App\Events\OrderPaid;
use App\Helpers\CustomHelper;
use App\Listeners\UpdateUserTier;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton('helper', function () {
            return new CustomHelper();
        });
    }

    public function boot(): void
    {
        // Force HTTPS for all asset links behind Zoraxy
        URL::forceScheme('https');

        Paginator::useBootstrapFour();

        Event::listen(
            OrderPaid::class,
            UpdateUserTier::class,
        );
    }
}
