<?php

namespace Kyranb\Footprints\Tests;

use Illuminate\Contracts\Http\Kernel as HttpKernel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Kyranb\Footprints\FootprintsServiceProvider;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    /**
     * Overriding getPackageProviders to load our package service provider.
     *
     * More details at: https://github.com/orchestral/testbench#custom-service-provider
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            FootprintsServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        // import the CreatePostsTable class from the migration
        include_once __DIR__ . '/../database/migrations/create_footprints_table.php.stub';

        // run the up() method of that migration class
        (new \CreateFootprintsTable)->up();
    }

    /**
     * Define routes setup.
     *
     * @param  \Illuminate\Routing\Router  $router
     *
     * @return void
     */
    protected function defineRoutes($router)
    {
        Route::get('/test', function () {
            return null;
        });
    }

    /**
     * Call the given URI and return the Response.
     *
     * @param  string  $method
     * @param  string  $uri
     * @param  array  $parameters
     * @param  array  $cookies
     * @param  array  $files
     * @param  array  $server
     * @param  string|null  $content
     * @return \Illuminate\Http\Request
     */
    public function makeRequest($method, $uri, $parameters = [], $cookies = [], $files = [], $server = [], $content = null)
    {
        $kernel = $this->app->make(HttpKernel::class);

        $files = array_merge($files, $this->extractFilesFromDataArray($parameters));

        $symfonyRequest = SymfonyRequest::create(
            $this->prepareUrlForRequest($uri), $method, $parameters,
            $cookies, $files, array_replace($this->serverVariables, $server), $content
        );

        return Request::createFromBase($symfonyRequest);
    }
}
