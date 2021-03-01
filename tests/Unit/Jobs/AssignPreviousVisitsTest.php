<?php

namespace Kyranb\Footprints\Tests\Unit\Jobs;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Kyranb\Footprints\Events\RegistrationTracked;
use Kyranb\Footprints\Jobs\AssignPreviousVisits;
use Kyranb\Footprints\Tests\TestCase;
use Kyranb\Footprints\TrackableInterface;
use Mockery\MockInterface;

class AssignPreviousVisitsTest extends TestCase
{
    public function test_emits_event_registration_tracked()
    {
        $request = $this->mock(Request::class, function (MockInterface $mock) {
            //
        });

        $trackable = $this->mock(TrackableInterface::class, function (MockInterface $mock) {
            $mock->shouldReceive('trackRegistration')->once();
        });

        Event::fake();

        $job = new AssignPreviousVisits($request, $trackable);
        $job->handle(); // We are not checking the "queue" part of the job, only that it does actually dispatch the event

        Event::assertDispatched(RegistrationTracked::class, function ($event) use ($trackable) {
            return $event->trackable === $trackable;
        });
    }
}
