<?php

namespace Kyranb\Footprints;

use Illuminate\Http\Response;
use Illuminate\Http\Request;

interface TrackingLoggerInterface
{
    /**
     * Determine whether or not the request should be tracked.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Http\Response $response
     * @return \Illuminate\Http\Response
     */
    public function track(Request $request, Response $response);
}
