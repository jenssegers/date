<?php

namespace Tests\Jenssegers;

use Carbon\Carbon;
use PHPUnit\Framework\TestCase;

class TestCaseBase extends TestCase
{
    const LOCALE = 'en';

    public function setUp()
    {
        date_default_timezone_set('UTC');
        Carbon::setLocale(static::LOCALE);

        // Freeze the time for the test duration
        Carbon::setTestNow(Carbon::now());
    }
}
