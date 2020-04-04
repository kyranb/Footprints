<?php

namespace Kyranb\Footprints\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Kyranb\Footprints\Visit;

class TrackVisit implements ShouldQueue
{
    use Queueable;

    private $attributionData;
    private $cookieToken;

    public function __construct($attributionData, $cookieToken)
    {
        $this->attributionData = $attributionData;
        $this->cookieToken = $cookieToken;
    }

    public function handle()
    {
        $user = [];
        $user[config('footprints.column_name')] = Auth::user() ? Auth::user()->id : null;

        $visit = Visit::create(array_merge([
            'cookie_token'      => $this->cookieToken,
            'landing_domain'    => $this->attributionData['landing_domain'],
            'landing_page'      => $this->attributionData['landing_page'],
            'landing_params'    => $this->attributionData['landing_params'],
            'referrer_domain'   => $this->attributionData['referrer']['referrer_domain'],
            'referrer_url'      => $this->attributionData['referrer']['referrer_url'],
            'gclid'             => $this->attributionData['gclid'],
            'utm_source'        => $this->attributionData['utm']['utm_source'],
            'utm_campaign'      => $this->attributionData['utm']['utm_campaign'],
            'utm_medium'        => $this->attributionData['utm']['utm_medium'],
            'utm_term'          => $this->attributionData['utm']['utm_term'],
            'utm_content'       => $this->attributionData['utm']['utm_content'],
            'referral'          => $this->attributionData['referral'],
            'created_at'        => $this->attributionData['created_at'],
            'updated_at'        => $this->attributionData['updated_at'],
        ], $this->attributionData['custom'], $user));

        return $visit->id;
    }
}
