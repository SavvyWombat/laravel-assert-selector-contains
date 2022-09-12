<?php

namespace SavvyWombat\LaravelAssertSelectorContains;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if (app()->runningUnitTests()) {
        }
    }
}
