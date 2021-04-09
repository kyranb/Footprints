<?php

namespace Kyranb\Footprints;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
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
        // Add an observer that upon registration will automatically sync up prior visits.
        static::created(function (Model $model) {
            $model->trackRegistration(request());
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
     * Method depricated use 'trackRegistration' method.
     *
     * @deprecated
     * @return void
     */
    public function assignPreviousVisits()
    {
        return $this->trackRegistration();
    }

    /**
     * Assign earlier visits using current request.
     */
    public function trackRegistration(Request $request): void
    {
        $job = new AssignPreviousVisits($request->footprint(), $this);

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
