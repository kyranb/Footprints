<?php

namespace Kyranb\Footprints\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Kyranb\Footprints\Visit;

class TrackVisit implements ShouldQueue
{
    use Queueable;

    protected array $attributionData;

    public function __construct(array $attributionData)
    {
        $this->attributionData = $attributionData;
    }

    public function handle()
    {
        Visit::create(array_merge([
            config('footprints.column_name') => Auth::user() ? Auth::user()->id : null,
        ], $this->attributionData));
    }
}
