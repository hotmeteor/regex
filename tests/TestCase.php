<?php

namespace Tests;

use Hotmeteor\Regex\RegexServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app)
    {
        return [RegexServiceProvider::class];
    }
}
