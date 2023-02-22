<?php

namespace Kyranb\Footprints;

use Illuminate\Http\Request;

interface FootprinterInterface
{
    /**
     * Calculate a footprint (identifier) for the request.
     *
     * Note that this method should be a "pure function" in the sense that any subsequent call to this method
     * should return the same string.
     */
    public function footprint(Request $request): string;
}
