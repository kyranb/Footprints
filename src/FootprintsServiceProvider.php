<?php

namespace Kyranb\Footprints;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class FootprintsServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     */
    public function boot()
    {
        $this->publishConfig();
        $this->publishMigration();
        $this->bootMacros();
    }

    /**
     * Publish Footprints configuration
     */
    protected function publishConfig()
    {
        // Publish config files
        $this->publishes([
            realpath(__DIR__.'/config/footprints.php') => config_path('footprints.php'),
        ], 'config');
    }

    /**
     * Publish Footprints migration
     */
    protected function publishMigration()
    {
        $published_migration = glob(database_path('/migrations/*_create_footprints_table.php'));
        if (count($published_migration) === 0) {
            $this->publishes([
                __DIR__.'/../database/migrations/create_footprints_table.php.stub' => database_path('/migrations/'.date('Y_m_d_His').'_create_footprints_table.php'),
            ], 'migrations');
        }
    }

    protected function bootMacros()
    {
        Request::macro('footprint', function () {
            return App::make(FootprinterInterface::class)->footprint($this);
        });
    }

    /**
     * Register any package services.
     */
    public function register()
    {
        // Bring in configuration values
        $this->mergeConfigFrom(
            __DIR__.'/config/footprints.php',
            'footprints'
        );

        $this->app->bind(TrackingFilterInterface::class, function ($app) {
            return $app->make(config('footprints.tracking_filter'));
        });

        $this->app->bind(TrackingLoggerInterface::class, function ($app) {
            return $app->make(config('footprints.tracking_logger'));
        });

        $this->app->singleton(FootprinterInterface::class, function ($app) {
            return $app->make(config('footprints.footprinter'));
        });

        $this->commands([
            Console\PruneCommand::class,
        ]);
    }
}
