# Footprints for Laravel 5.1+

![Footprints for Laravel 5.1+](readme-header.jpg)

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Total Downloads][ico-downloads]][link-downloads]


Footprints is a simple registration attribution tracking solution for Laravel 5.1+

> “I know I waste half of my advertising dollars...I just wish I knew which half.” ~ *Henry Procter*.

By tracking where user signups (or any other kind of registrations) originate from you can ensure that your marketing efforts are more focused.

Footprints makes it easy to look back and see what lead to a user signing up.

## Install

Via Composer

``` bash
$ composer require kyranb/footprints
```

Add the ServiceProvider and Alias to their relative arrays in config/app.php:

``` php

    'providers' => [
        ...
        Kyranb\Footprints\FootprintsServiceProvider::class,
    ],

...

    'aliases' => [
        ...
        'Footprints'   => Kyranb\Footprints\Facades\Footprints::class,
    ],

```

Publish the config and migration files:

``` php
php artisan kyranb:publish --provider="Kyranb\Footprints\FootprintsServiceProvider"
```

Add the ```TrackRegistrationAttribution``` trait to the model you wish to track attributions for. For example:



```php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Kyranb\Footprints\TrackRegistrationAttribution;

class User extends Model
{
    use Authenticatable, TrackRegistrationAttribution;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

}


```

Go over the configuration file, most notably the model you wish to track:

``` 'model' => 'App\User' ```

the column name:

``` 'model_column_name' => 'user_id' ```

and attribution duration (in seconds)

``` 'attribution_duration' => 2628000 ```


## Usage

#### What data is tracked for each visit?

* landing_page
* referrer_url
* referrer_domain
* utm_medium
* utm_term
* created_at (date of visit)

##### Get all of a user's visits before registering.
``` php
$user = User::find(1);
$user->visits;
```

##### Get the attribution data of a user's initial visit before registering.
``` php
$user = User::find(1);
$user->initialAttributionData();
```

##### Get the attribution data of a user's final visit before registering.
``` php
$user = User::find(1);
$user->finalAttributionData();
```

## Change log

Please see the commit history for more information what has changed recently.

## Testing

Haven't got round to this yet - PR's welcome ;)

``` bash
$ composer test
```

## Contributing

If you run into any issues, have suggestions or would like to expand this packages functionality, please open an issue or a pull request :)



## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/kyranb/footprints.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/kyranb/footprints/master.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/kyranb/footprints.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/kyranb/footprints
[link-travis]: https://travis-ci.org/kyranb/footprints
[link-downloads]: https://packagist.org/packages/kyranb/footprints
[link-author]: https://github.com/kyranb
[link-contributors]: ../../contributors
