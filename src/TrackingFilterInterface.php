<?php

namespace Kyranb\Footprints;

use Illuminate\Http\Request;

interface TrackingFilterInterface
{
    /**
     * Determine whether or not the request should be tracked.
     */
    public function shouldTrack(Request $request): bool;
}
