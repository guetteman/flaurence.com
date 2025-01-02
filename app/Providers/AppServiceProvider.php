<?php

namespace App\Providers;

use App\Subscribers\BillingEventSubscriber;
use Event;
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
        Event::subscribe(BillingEventSubscriber::class);
    }
}
