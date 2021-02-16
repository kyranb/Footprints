<?php

namespace Kyranb\Footprints;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class Footprinter implements FootprinterInterface
{
    protected Request $request;

    protected string $random;

    public function __construct()
    {
        $this->random = Str::random(20); // Will only be set once during requests since this class is a singleton
    }

    /** @inheritDoc */
    public function footprint(Request $request): string
    {
        $this->request = $request;

        if ($request->hasCookie(config('footprints.cookie_name'))) {
            return $request->cookie(config('footprints.cookie_name'));
        }

        // This will add the cookie to the response
        Cookie::queue(
            config('footprints.cookie_name'),
            $footprint = $this->fingerprint(),
            config('footprints.attribution_duration'),
            null,
            config('footprints.cookie_domain')
        );

        return $footprint;
    }

    /**
     * This method will generate a fingerprint for the request based on the configuration.
     *
     * If relying on cookies then the logic of this function is not important, but if cookies are disabled this value
     * will be used to link previous requests with one another.
     *
     * @return string
     */
    protected function fingerprint()
    {
        // This is highly inspired from the $request->fingerprint() method
        return sha1(implode('|', array_filter([
            $this->request->ip(),
            $this->request->header('user-agent'),
            config('footprints.uniqueness') ? $this->random : null,
        ])));
    }
}
