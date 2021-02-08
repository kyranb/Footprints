<?php

namespace Kyranb\Footprints\Tests;

use Kyranb\Footprints\FootprintsFacade;
use Kyranb\Footprints\FootprintsServiceProvider;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    /**
     * Overriding getPackageProviders to load our package service provider.
     *
     * More details at: https://github.com/orchestral/testbench#custom-service-provider
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            FootprintsServiceProvider::class,
        ];
    }

    /**
     * Overriding getPackageAliases to load our package alias.
     *
     * Mode details at: https://github.com/orchestral/testbench#custom-aliases
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return array
     */
    protected function getPackageAliases($app)
    {
        return [
            'Ais' => FootprintsFacade::class,
        ];
    }
}
