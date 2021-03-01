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

class AssignPreviousVisits implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Request $request;
    protected TrackableInterface $trackable;

    public function __construct(Request $request, TrackableInterface $trackable)
    {
        $this->request = $request;
        $this->trackable = $trackable;
    }

    public function handle()
    {
        $this->trackable->trackRegistration($this->request);

        event(new RegistrationTracked($this->trackable));
    }
}
