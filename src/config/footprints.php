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
    | Attribution Duration
    |--------------------------------------------------------------------------
    |
    | How long since the initial visit should an attribution last for.
    |
    */

    'attribution_duration' => 2628000,

];
