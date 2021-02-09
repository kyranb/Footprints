<?php

namespace Kyranb\Footprints\Middleware;

use Closure;

use Illuminate\Http\Request;
use Kyranb\Footprints\TrackingFilterInterface;
use Kyranb\Footprints\TrackingLoggerInterface;

class CaptureAttributionDataMiddleware
{
    protected $filter;

    protected $logger;

    public function __construct(TrackingFilterInterface $filter, TrackingLoggerInterface $logger)
    {
        $this->filter = $filter;
        $this->logger = $logger;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if ($this->filter->shouldTrack($request, $response)) {
            return $this->logger->track($request, $response);
        }

        return $response;
    }
}
