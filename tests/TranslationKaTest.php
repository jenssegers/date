<?php

use Jenssegers\Date\Date;
use PHPUnit\Framework\TestCase;

class TranslationKaTest extends TestCase
{
    public function setUp()
    {
        date_default_timezone_set('UTC');
        Date::setTestNow(Date::now());
        Date::setLocale('ka');
    }

    public function testTimespanTranslated()
    {
        $date = new Date(1403619368);
        $date = $date->sub('-100 days -3 hours -20 minutes');

        $this->assertSame('3 თვის, 1 კვირის, 1 დღის, 3 საათის, 20 წუთის', $date->timespan(1403619368));
    }

    public function testCreateFromFormat()
    {
        $date = Date::createFromFormat('d F Y', '1 იანვარი 2015');
        $this->assertSame('2015-01-01', $date->format('Y-m-d'));

        $date = Date::createFromFormat('D d F Y', 'შაბათი 21 მარტი 2015');
        $this->assertSame('2015-03-21', $date->format('Y-m-d'));
    }

    public function testAgoTranslated()
    {
        $date = Date::parse('-21 hours');
        $this->assertSame('21 საათის წინ', $date->ago());

        $date = Date::parse('-5 days');
        $this->assertSame('5 დღის წინ', $date->ago());

        $date = Date::parse('-3 weeks');
        $this->assertSame('3 კვირის წინ', $date->ago());

        $date = Date::parse('-6 months');
        $this->assertSame('6 თვის წინ', $date->ago());

        $date = Date::parse('-10 years');
        $this->assertSame('10 წლის წინ', $date->ago());
    }

    public function testFormatDeclensions()
    {
        $date = new Date('10 march 2015');
        $this->assertSame('მარტი 2015', $date->format('F Y'));

        $date = new Date('10 march 2015');
        $this->assertSame('10 მარტი 2015', $date->format('j F Y'));
    }

    public function testAfterTranslated()
    {
        $date = Date::parse('+21 hours');
        $this->assertSame('21 საათის შემდეგ', $date->ago());

        $date = Date::parse('+5 days');
        $this->assertSame('5 დღის შემდეგ', $date->ago());

        $date = Date::parse('+3 weeks');
        $this->assertSame('3 კვირის შემდეგ', $date->ago());

        $date = Date::parse('+6 months');
        $this->assertSame('6 თვის შემდეგ', $date->ago());

        $date = Date::parse('+10 years');
        $this->assertSame('10 წლის შემდეგ', $date->ago());
    }
}
