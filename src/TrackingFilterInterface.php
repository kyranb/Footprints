<?php

namespace Kyranb\Footprints;

use Illuminate\Http\Response;
use Illuminate\Http\Request;

interface TrackingFilterInterface
{
    /**
     * Determine whether or not the request should be tracked.
     *
     * @param \Illuminate\Http\Request $request
     * @return bool
     */
    public function shouldTrack(Request $request): bool;
}
