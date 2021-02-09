<?php

namespace Kyranb\Footprints\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Kyranb\Footprints\Visit;

class TrackVisit implements ShouldQueue
{
    use Queueable;

    /** @var array */
    protected $attributionData;

    /** @var string */
    protected $cookieToken;

    public function __construct(array $attributionData, string $cookieToken)
    {
        $this->attributionData = $attributionData;
        $this->cookieToken = $cookieToken;
    }

    public function handle()
    {
        Visit::create(array_merge([
            'cookie_token'      => $this->cookieToken,
            config('footprints.column_name') => Auth::user() ? Auth::user()->id : null,
        ], $this->attributionData));
    }
}
