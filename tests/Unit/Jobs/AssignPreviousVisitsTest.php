<?php

namespace Kyranb\Footprints\Tests\Unit\Jobs;

use Illuminate\Support\Facades\Event;
use Kyranb\Footprints\Events\RegistrationTracked;
use Kyranb\Footprints\Jobs\AssignPreviousVisits;
use Kyranb\Footprints\Tests\TestCase;
use Kyranb\Footprints\TrackableInterface;
use Mockery\MockInterface;

class AssignPreviousVisitsTest extends TestCase
{
    public function test_emits_registration_tracked_event()
    {
        $trackable = $this->mock(TrackableInterface::class, function (MockInterface $mock) {
            $mock->id = 123;
        });

        Event::fake();

        $job = new AssignPreviousVisits('test-footprint', $trackable);
        $job->handle(); // We are not checking the "queue" part of the job, only that it does actually dispatch the event

        Event::assertDispatched(RegistrationTracked::class, function ($event) use ($trackable) {
            return $event->trackable === $trackable
                && $event->footprint = 'test-footprint';
        });
    }
}
