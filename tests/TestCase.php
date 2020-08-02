<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function makePathToFixtures($file)
    {
        $parts = [__DIR__, "fixtures", $file];
        return implode("/", $parts);
    }
}
