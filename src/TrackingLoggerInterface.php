<?php

namespace Kyranb\Footprints;

use Illuminate\Http\Request;

interface TrackingLoggerInterface
{
    /**
     * Track the request.
     */
    public function track(Request $request): Request;
}
