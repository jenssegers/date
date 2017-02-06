<?php

use Carbon\Carbon;
use Jenssegers\Date\Date;

class DateTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        date_default_timezone_set('UTC');
        Date::setLocale('en');
    }

    public function testConstructs()
    {
        $date = new Date;
        $this->assertInstanceOf('Jenssegers\Date\Date', $date);
    }

    public function testStaticConstructor()
    {
        $date = new Date;
        $now1 = Date::now();
        $now2 = new Date('now');
        $this->assertEquals($date, $now1);
        $this->assertEquals($date, $now2);
    }

    public function testConstructFromString()
    {
        $date = new Date('2013-01-31');
        $this->assertSame(1359590400, $date->getTimestamp());

        $date = new Date('1 day ago');
        $this->assertSame(time() - 86400, $date->getTimestamp());
    }

    public function testConstructWithTimezone()
    {
        $date = new Date('now', 'Europe/Paris');
        date_default_timezone_set('Europe/Paris');
        $this->assertSame(time(), $date->getTimestamp());

        date_default_timezone_set('Europe/Brussels');

        $date = new Date(null, 'Europe/Paris');
        date_default_timezone_set('Europe/Paris');
        $this->assertSame(time(), $date->getTimestamp());
    }

    public function testConstructTimestamp()
    {
        $date = new Date(1367186296);
        $this->assertSame(1367186296, $date->getTimestamp());
    }

    public function testMake()
    {
        $now1 = Date::make('now');
        $now2 = new Date('now');
        $this->assertEquals($now1, $now2);
    }

    public function testCreateFromCarbon()
    {
        $date = Date::make(Carbon::createFromFormat('U', 1367186296));
        $this->assertInstanceOf('Jenssegers\Date\Date', $date);
        $this->assertEquals(1367186296, $date->getTimestamp());
    }

    public function testManipulation()
    {
        $now = Date::now();

        $this->assertSame(86400, Date::now()->add('1 day')->getTimestamp() - Date::now()->getTimestamp());
        $this->assertSame(4 * 86400, Date::now()->add('4 day')->getTimestamp() - Date::now()->getTimestamp());

        $this->assertSame(-86400, Date::now()->sub('1 day')->getTimestamp() - Date::now()->getTimestamp());
        $this->assertSame(-4 * 86400, Date::now()->sub('4 day')->getTimestamp() - Date::now()->getTimestamp());

        $this->assertSame(10 * 86400, Date::now()->add('P10D')->getTimestamp() - Date::now()->getTimestamp());
        $this->assertSame(-10 * 86400, Date::now()->sub('P10D')->getTimestamp() - Date::now()->getTimestamp());
    }

    public function testFormat()
    {
        $date = new Date(1367186296);
        $this->assertSame('Sunday 28 April 2013 21:58:16', $date->format('l j F Y H:i:s'));
    }

    public function testAge()
    {
        $date = Date::parse('-5 years');
        $this->assertSame(5, $date->age);
    }

    public function testAgo()
    {
        $date = Date::parse('-5 years');
        $this->assertSame('5 years ago', $date->ago());

        $date = Date::parse('-5 months');
        $this->assertSame('5 months ago', $date->ago());

        $date = Date::parse('-32 days');
        $this->assertSame('1 month ago', $date->ago());

        $date = Date::parse('-4 days');
        $this->assertSame('4 days ago', $date->ago());

        $date = Date::parse('-1 day');
        $this->assertSame('1 day ago', $date->ago());

        $date = Date::parse('-3 hours');
        $this->assertSame('3 hours ago', $date->ago());

        $date = Date::parse('-1 hour');
        $this->assertSame('1 hour ago', $date->ago());

        $date = Date::parse('-2 minutes');
        $this->assertSame('2 minutes ago', $date->ago());

        $date = Date::parse('-1 minute');
        $this->assertSame('1 minute ago', $date->ago());

        $date = Date::parse('-50 second');
        $this->assertSame('50 seconds ago', $date->ago());

        $date = Date::parse('-1 second');
        $this->assertSame('1 second ago', $date->ago());

        $date = Date::parse('+5 days');
        $this->assertSame('5 days from now', $date->ago());

        $date = Date::parse('+5 days');
        $this->assertSame('5 days after', $date->ago(Date::now()));

        $date = Date::parse('-5 days');
        $this->assertSame('5 days before', $date->ago(Date::now()));
    }

    public function testAbsoluteAgo()
    {
        $date = Date::parse('-5 days');
        $this->assertSame('5 days', $date->ago(Date::now(), true));

        $date = Date::parse('+5 days');
        $this->assertSame('5 days', $date->ago(Date::now(), true));
    }

    public function testDiffForHumans()
    {
        $date = Date::parse('-5 years');
        $this->assertSame('5 years ago', $date->diffForHumans());
    }

    public function testTimespan()
    {
        $date = new Date(1403619368);
        $date = $date->sub('-100 days -3 hours -20 minutes');

        $this->assertSame('3 months, 1 week, 1 day, 3 hours, 20 minutes', $date->timespan(1403619368));
    }

    public function testTranslateTimeString()
    {
        Date::setLocale('ru');
        $date = Date::translateTimeString('понедельник 21 март 2015');
        $this->assertSame('monday 21 march 2015', $date);

        Date::setLocale('de');
        $date = Date::translateTimeString('Montag 21 März 2015');
        $this->assertSame('monday 21 march 2015', $date);
    }
}
