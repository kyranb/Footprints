<?php

namespace Kyranb\Footprints;

use Illuminate\Support\Facades\Facade;

class FootprintsFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return Footprints::class;
    }
}
