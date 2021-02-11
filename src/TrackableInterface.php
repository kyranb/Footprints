<?php

namespace Kyranb\Footprints;

use Illuminate\Http\Request;

interface TrackableInterface
{
    /**
     * Assign earlier visits using current request.
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function trackRegistration(Request $request): void;
}
