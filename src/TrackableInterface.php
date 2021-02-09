<?php

namespace Kyranb\Footprints;

use Illuminate\Http\Request;

interface TrackableInterface
{
    /**
     * Assign earlier visits using current request.
     */
    public function trackRegistration(Request $request);
}
