<?php

namespace Kyranb\Footprints;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class Footprinter implements FootprinterInterface
{
    /** @inheritDoc */
    public function footprint(Request $request)
    {
        if ($request->hasCookie(config('footprints.cookie_name'))) {
            return $request->cookie(config('footprints.cookie_name'));
        }

        // This will add the cookie to the response
        Cookie::queue(
            config('footprints.cookie_name'),
            $footprint = $request->fingerprint(),
            config('footprints.attribution_duration'),
            null,
            config('footprints.cookie_domain')
        );

        return $footprint;
    }
}
