<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Database connection name
    |--------------------------------------------------------------------------
    |
    | The name of the database connection if not the default
    |
    */
    'connection_name' => null,

    /*
    |--------------------------------------------------------------------------
    | Table Name
    |--------------------------------------------------------------------------
    |
    | The name of the database table that will hold UTM data
    |
    */
    'table_name' => 'visits',

    /*
    |--------------------------------------------------------------------------
    | Model
    |--------------------------------------------------------------------------
    |
    | The model to track attribution events for.
    |
    */
    'model' => 'App\Models\User',

    /*
    |--------------------------------------------------------------------------
    | Guard
    |--------------------------------------------------------------------------
    |
    | The authentication guard to use.
    |
    */
    'guard' => 'web',

    /*
    |--------------------------------------------------------------------------
    | Relationship Column Name
    |--------------------------------------------------------------------------
    |
    | The column that defines the relation between tracked vists and the model.
    |
    */
    'column_name' => 'user_id',

    /*
    |--------------------------------------------------------------------------
    | Cookie Name
    |--------------------------------------------------------------------------
    |
    | The name of the cookie that is set to keep track of attributions.
    |
    */
    'cookie_name' => 'footprints',

    /*
    |--------------------------------------------------------------------------
    | Tracking Filter
    |--------------------------------------------------------------------------
    |
    | This class is responsible for determining if a request should be logged
    | or not. Setting this to another implementation makes it possible to
    | customize the logic. Note that the class must implement the
    | TrackingFilterInterface.
    |
    */
    'tracking_filter' => \Kyranb\Footprints\TrackingFilter::class,

    /*
    |--------------------------------------------------------------------------
    | Tracking Logger
    |--------------------------------------------------------------------------
    |
    | This class is responsible for logging the request. Setting this to
    | another implementation makes it possible to customize the logic. Note
    | that the class must implement the TrackingLoggerInterface.
    |
    */
    'tracking_logger' => \Kyranb\Footprints\TrackingLogger::class,

    /*
    |--------------------------------------------------------------------------
    | Footprinter
    |--------------------------------------------------------------------------
    |
    | This class is responsible for generatin a digital footprint (string) of
    | the request. The default implementation will check for the presence of
    | a footprint cookie and return this. If no cookie is found then it returns
    | the requests fingerprint - se Laravel Docs for this method.
    |
    */
    'footprinter' => \Kyranb\Footprints\Footprinter::class,

    /*
    |--------------------------------------------------------------------------
    | Footprinting uniqueness
    |--------------------------------------------------------------------------
    |
    | If this setting is disabled then a semi-unique footprint will be generated
    | for the request. The purpose of this is to anable tracking accross,
    | browsers or where cookies might be blocked.
    |
    | Note that enabling this could cause request from different users using
    | the same ip to be matched.
    |
    */
    'uniqueness' => true,

    /*
    |--------------------------------------------------------------------------
    | Attribution Duration
    |--------------------------------------------------------------------------
    |
    | How long since the initial visit should an attribution last for.
    |
    */
    'attribution_duration' => 2628000,

    /*
    |--------------------------------------------------------------------------
    | Ip logging
    |--------------------------------------------------------------------------
    |
    | Determine if the users IP address should be loged or not.
    |
    */
    'attribution_ip' => false,

    /*
    |--------------------------------------------------------------------------
    | Custom tracking parameter
    |--------------------------------------------------------------------------
    |
    |
    */
    'custom_parameters' => [],

    /*
    |--------------------------------------------------------------------------
    | Tracking settings
    |--------------------------------------------------------------------------
    |
    | Robots tracking are for instance search engine. Since they will never
    | register, it might be interesting to not track them to save space.
    |
    */
    'disable_on_authentication' => true,
    'disable_internal_links' => true,
    'disable_robots_tracking' => false,

    /*
    |--------------------------------------------------------------------------
    | Disable Routes
    |--------------------------------------------------------------------------
    |
    |
    */
    'landing_page_blacklist' => [

        'genealabs/laravel-caffeine/drip'
    ],

    /*
    |--------------------------------------------------------------------------
    | Cookie domain
    |--------------------------------------------------------------------------
    |
    | If you want to use with more subdomain
    | you have to set this to .yourdomain.com
    |
    */
    'cookie_domain' => config('session.domain'),

    /*
    |--------------------------------------------------------------------------
    | Async
    |--------------------------------------------------------------------------
    |
    | This function will use the laravel queue.
    | Make sure your setup is correct.
    |
    */
    'async' => false,
];
