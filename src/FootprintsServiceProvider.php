<?php

namespace Kyranb\Footprints;

use Kyranb\Footprints\Facades\FootprintsFacade;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class FootprintsServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     */
    public function boot()
    {
        $this->publishes([
            realpath(__DIR__.'/config/footprints.php') => config_path('footprints.php'),
        ]);

        $this->publishes([
               __DIR__.'/database/migrations/migrations.stub' => database_path('/migrations/'.date('Y_m_d_His').'_create_visits_table.php'),
           ], 'migrations');

    }

    /**
     * Register any package services.
     */
    public function register()
    {
        // Bring in configuration values
        $this->mergeConfigFrom(
              __DIR__.'/config/footprints.php', 'footprints'
           );

        $this->app->singleton(Footprints::class, function () {
            return new Footprints();
        });

        // Define alias 'Footprints'
        $this->app->booting(function () {
            $loader = AliasLoader::getInstance();

            $loader->alias('Footprints', FootprintsFacade::class);
        });
    }
}
