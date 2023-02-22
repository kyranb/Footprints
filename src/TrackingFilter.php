<?php

namespace Kyranb\Footprints;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Jaybizzle\CrawlerDetect\CrawlerDetect;

class TrackingFilter implements TrackingFilterInterface
{
    /**
     * The Request instance.
     */
    protected Request $request;

    /**
     * Determine whether or not the request should be tracked.
     */
    public function shouldTrack(Request $request): bool
    {
        $this->request = $request;

        //Only track get requests
        if (! $this->request->isMethod('get')) {
            return false;
        }

        if ($this->disableOnAuthentication()) {
            return false;
        }

        if ($this->disableInternalLinks()) {
            return false;
        }

        if ($this->disabledLandingPages($this->captureLandingPage())) {
            return false;
        }

        if ($this->disableRobotsTracking()) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    protected function disableOnAuthentication()
    {
        if (Auth::guard(config('footprints.guard'))->check() && config('footprints.disable_on_authentication')) {
            return true;
        }
    }

    /**
     * @return bool
     */
    protected function disableInternalLinks()
    {
        if (! config('footprints.disable_internal_links')) {
            return false;
        }

        if ($referrer_domain = $this->request->headers->get('referer')) {
            $referrer_domain = parse_url($referrer_domain)['host'] ?? null;
            $request_domain = $this->request->server('SERVER_NAME');

            if ($referrer_domain && ($referrer_domain === $request_domain)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param  string  $landing_page
     * @return  array|bool
     */
    protected function disabledLandingPages($landing_page = null)
    {
        $blacklist = (array) config('footprints.landing_page_blacklist');

        if ($landing_page) {
            $k = array_search($landing_page, $blacklist);

            return $k === false ? false : true;
        } else {
            return $blacklist;
        }
    }

    /**
     * @return string
     */
    protected function captureLandingPage()
    {
        return $this->request->path();
    }

    /**
     * @return bool
     */
    protected function disableRobotsTracking()
    {
        if (! config('footprints.disable_robots_tracking')) {
            return false;
        }

        return (new CrawlerDetect)->isCrawler();
    }
}
