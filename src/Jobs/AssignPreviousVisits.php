<?php

namespace Kyranb\Footprints\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Kyranb\Footprints\Events\RegistrationTracked;
use Kyranb\Footprints\TrackableInterface;
use Kyranb\Footprints\Visit;

class AssignPreviousVisits implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $footprint;
    protected TrackableInterface $trackable;

    public function __construct(string $footprint, TrackableInterface $trackable)
    {
        $this->footprint = $footprint;
        $this->trackable = $trackable;
    }

    public function handle()
    {
        Visit::unassignedPreviousVisits($this->footprint)->update(
            [
                config('footprints.column_name') => $this->trackable->id,
            ]
        );

        event(new RegistrationTracked($this->trackable));
    }
}
