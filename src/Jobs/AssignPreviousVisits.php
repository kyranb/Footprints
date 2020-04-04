<?php

namespace Kyranb\Footprints\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Cookie;
use Kyranb\Footprints\Visit;

class AssignPreviousVisits implements ShouldQueue
{
    use Queueable;

    private $cookie;
    private $id;

    public function __construct($cookie, $id)
    {
        $this->cookie = $cookie;
        $this->id = $id;
    }

    public function handle()
    {
        Visit::unassignedPreviousVisits($this->cookie)->update(
            [
                config('footprints.column_name') => $this->id
            ]
        );
    }
}
