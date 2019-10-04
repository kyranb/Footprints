<?php

namespace Kyranb\Footprints;

use Cookie;
use Illuminate\Database\Eloquent\Model;
use Kyranb\Footprints\Jobs\AssignPreviousVisits;

/**
 * Class TrackRegistrationAttribution.
 *
 * @method static void created(callable $callback)
 */
trait TrackRegistrationAttribution
{
    public static function bootTrackRegistrationAttribution()
    {
        $footprints = app(Footprints::class);

        // Add an observer that upon registration will automatically sync up prior visits.
        static::created(function (Model $model) {
            $model->assignPreviousVisits();
        });
    }

    /**
     * Get all of the visits for the user.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function visits()
    {
        return $this->hasMany(Visit::class, config('footprints.column_name'))->orderBy('created_at', 'desc');
    }

    /**
     * Sync visits from the logged in user before they registered.
     *
     */
    public function assignPreviousVisits()
    {
        $cookie = Cookie::get(config('footprints.cookie_name'));
        $job = new AssignPreviousVisits($cookie, $this->id);

        if (config('footprints.async') == true) {
            dispatch($job);
        } else {
            $job->handle();
        }

    }

    /**
     * The initial attribution data that eventually led to a registration.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function initialAttributionData()
    {
        return $this->visits()->orderBy('created_at', 'asc')->first();
    }

    /**
     * The final attribution data before registration.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function finalAttributionData()
    {
        return $this->visits()->orderBy('created_at', 'desc')->first();
    }
}
