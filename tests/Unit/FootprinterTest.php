<?php

namespace Kyranb\Footprints\Tests\Unit;

use Illuminate\Routing\Route;
use Kyranb\Footprints\Tests\TestCase;

class FootprinterTest extends TestCase
{
    public function test_is_a_pure_function_when_cookie()
    {
        $request = $this->makeRequest('GET', '/test', [], [config('footprints.cookie_name') => 'testing']);

        $footprint1 = $request->footprint();
        $footprint2 = $request->footprint();

        $this->assertNotEmpty($footprint1);
        $this->assertNotEmpty($footprint2);
        $this->assertEquals($footprint1, $footprint2);
    }

    public function test_is_a_pure_function_when_no_cookie()
    {
        $request = $this->makeRequest('GET', '/test');
        $request->setRouteResolver(function () {
            return new Route(['GET'], '/test', ['test1', 'test2']);
        });

        $footprint1 = $request->footprint();
        $footprint2 = $request->footprint();

        $this->assertNotEmpty($footprint1);
        $this->assertNotEmpty($footprint2);
        $this->assertEquals($footprint1, $footprint2);
    }
}
