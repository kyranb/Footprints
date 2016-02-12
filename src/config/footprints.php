<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Model
    |--------------------------------------------------------------------------
    |
    | The model to track attribution events for.
    |
    */

    'model' => 'App\User',

   /*
   |--------------------------------------------------------------------------
   | Relationship Column Name
   |--------------------------------------------------------------------------
   |
   | The column that defines the relation between tracked vists and the model.
   |
   */

   'model_column_name' => 'user_id',

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
    | Attribution Duration
    |--------------------------------------------------------------------------
    |
    | How long since the initial visit should an attribution last for.
    |
    */

    'attribution_duration' => 2628000,

    /*
    |--------------------------------------------------------------------------
    | Global Middleware
    |--------------------------------------------------------------------------
    |
    | Leave this enabled unless you wish to implement the same functionality
    | as the CaptureReferrerDataMiddleware
    |
    */

    'global_middleware' => true,

];
