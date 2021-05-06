<?php

namespace Kyranb\Footprints\Console;

use Illuminate\Console\Command;
use Kyranb\Footprints\Visit;

class PruneCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'footprints:prune {--days : The number of days to retain unassigned Footprints data}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Prune stale (ie unassigned) entries from the Footprints database';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $days = $this->option('days') ?? config('footprints.attribution_duration') / (60 * 60 * 24);

        return Visit::unassignedPreviousVisits()
            ->where('created_at', '<=', today()->subDays($days))
            ->delete();
    }
}
