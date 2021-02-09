<?php

namespace Kyranb\Footprints\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use Kyranb\Footprints\TrackableInterface;

class AssignPreviousVisits implements ShouldQueue
{
    use Queueable;

    private $request;
    private $trackable;

    public function __construct(Request $request, TrackableInterface $trackable)
    {
        $this->request = $request;
        $this->trackable = $trackable;
    }

    public function handle()
    {
        $this->trackable->trackRegistration($this->request);
    }
}
