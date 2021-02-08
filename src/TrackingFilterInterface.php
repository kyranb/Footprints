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
     * @param \Illuminate\Http\Response $response
     * @return bool
     */
    public function shouldTrack(Request $request, Response $response);
}
