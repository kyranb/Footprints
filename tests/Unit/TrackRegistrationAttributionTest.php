<?php

namespace Kyranb\Footprints\Tests\Unit;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Config;
use Kyranb\Footprints\Jobs\AssignPreviousVisits;
use Kyranb\Footprints\Tests\TestCase;
use Kyranb\Footprints\TrackableInterface;
use Kyranb\Footprints\TrackRegistrationAttribution;
use Mockery\MockInterface;

class TrackRegistrationAttributionTest extends TestCase
{
    /** @test */
    public function test_dispatches_assign_previous_visits_job_when_configured_as_async()
    {
        Config::set('footprints.async', true);

        Bus::fake();

        $request = $this->mock(Request::class, function (MockInterface $mock) {
            $mock->shouldReceive('footprint')->andReturn('ABC123');
        });

        $trackable = new User;

        $trackable->trackRegistration($request);

        Bus::assertDispatched(AssignPreviousVisits::class, function ($job) use ($trackable) {
            return $job->footprint == 'ABC123' && $job->trackable == $trackable;
        });
    }

    /** @test */
    public function test_does_not_dispatch_assign_previous_visits_job_when_configured_as_sync()
    {
        Config::set('footprints.async', false);

        Bus::fake();

        (new User)->trackRegistration(new Request());

        Bus::assertNotDispatched(AssignPreviousVisits::class);
    }
}

class User implements TrackableInterface
{
    use TrackRegistrationAttribution;

    public $id = 123;
}
