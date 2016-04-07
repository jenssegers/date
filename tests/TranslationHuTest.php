<?php

use Jenssegers\Date\Date;
use Symfony\Component\Translation\Loader\ArrayLoader;
use Symfony\Component\Translation\Translator;

class TranslationHuTest extends PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        date_default_timezone_set('UTC');
        Date::setLocale('hu');
    }

    public function testGetsAndSetsTranslator()
    {
        $translator = new Translator('hu');
        $translator->addLoader('array', new ArrayLoader());
        $this->assertNotEquals($translator, Date::getTranslator());

        Date::setTranslator($translator);
        $this->assertEquals($translator, Date::getTranslator());
    }

    public function testTimespanTranslated()
    {
        $date = new Date(1403619368);
        $date = $date->sub('-100 days -3 hours -20 minutes');

        $this->assertSame('3 hónap, 1 hét, 1 nap, 3 óra, 20 perc', $date->timespan(1403619368));
    }

    public function testAgoTranslated()
    {
        $date = Date::parse('-1 minute');
        $this->assertSame('1 perce ezelőtt', $date->ago());

        $date = Date::parse('-21 hours');
        $this->assertSame('21 órája ezelőtt', $date->ago());

        $date = Date::parse('-5 days');
        $this->assertSame('5 napja ezelőtt', $date->ago());

        $date = Date::parse('-3 weeks');
        $this->assertSame('3 hete ezelőtt', $date->ago());

        $date = Date::parse('-6 months');
        $this->assertSame('6 hónapja ezelőtt', $date->ago());

        $date = Date::parse('-10 years');
        $this->assertSame('10 éve ezelőtt', $date->ago());
    }

    public function testFromNowTranslated()
    {
        $date = Date::parse('+1 minute');
        $this->assertSame('1 perc ezután', $date->ago());

        $date = Date::parse('+21 hours');
        $this->assertSame('21 óra ezután', $date->ago());

        $date = Date::parse('+5 days');
        $this->assertSame('5 nap ezután', $date->ago());

        $date = Date::parse('+3 weeks');
        $this->assertSame('3 hét ezután', $date->ago());

        $date = Date::parse('+6 months');
        $this->assertSame('6 hónap ezután', $date->ago());

        $date = Date::parse('+10 years');
        $this->assertSame('10 év ezután', $date->ago());
    }

    public function testAfterTranslated()
    {
        $date = Date::parse('+21 hours');
        $this->assertSame('21 órával később', $date->ago(Date::now()));

        $date = Date::parse('+5 days');
        $this->assertSame('5 nappal később', $date->ago(Date::now()));

        $date = Date::parse('+3 weeks');
        $this->assertSame('3 héttel később', $date->ago(Date::now()));

        $date = Date::parse('+6 months');
        $this->assertSame('6 hónappal később', $date->ago(Date::now()));

        $date = Date::parse('+10 years');
        $this->assertSame('10 évvel később', $date->ago(Date::now()));
    }

    public function testBeforeTranslated()
    {
        $date = Date::parse('-21 hours');
        $this->assertSame('21 órával korábban', $date->ago(Date::now()));

        $date = Date::parse('-5 days');
        $this->assertSame('5 nappal korábban', $date->ago(Date::now()));

        $date = Date::parse('-3 weeks');
        $this->assertSame('3 héttel korábban', $date->ago(Date::now()));

        $date = Date::parse('-6 months');
        $this->assertSame('6 hónappal korábban', $date->ago(Date::now()));

        $date = Date::parse('-10 years');
        $this->assertSame('10 évvel korábban', $date->ago(Date::now()));
    }

    public function testCreateFromFormat()
    {
        $date = Date::createFromFormat('Y. F d.', '2015. január 1.');
        $this->assertSame('2015-01-01', $date->format('Y-m-d'));

        $date = Date::createFromFormat('Y. F d., D', '2015. március 21., szombat');
        $this->assertSame('2015-03-21', $date->format('Y-m-d'));
    }
}
