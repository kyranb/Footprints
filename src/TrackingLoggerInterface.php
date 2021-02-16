<?php

namespace Kyranb\Footprints;

use Illuminate\Http\Request;

interface TrackingLoggerInterface
{
    /**
     * Track the request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Request
     */
    public function track(Request $request): Request;
}
