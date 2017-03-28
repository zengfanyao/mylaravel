<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use JiaLeo\Laravel\Core\CoreTests;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, CoreTests;
}
