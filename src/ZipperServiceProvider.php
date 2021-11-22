<?php

namespace SquareetLabs\Zipper;


use Illuminate\Support\ServiceProvider;

class ZipperServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->app->singleton(Zipper::class, function () {
            return new Zipper();
        });
        $this->app->alias(Zipper::class, 'zipper');

    }
}
