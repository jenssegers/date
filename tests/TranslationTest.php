<?php

use Jenssegers\Date\Date;
use Symfony\Component\Translation\Loader\ArrayLoader;
use Symfony\Component\Translation\Translator;

class TranslationTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        date_default_timezone_set('UTC');
    }

    public function testGetsAndSetsTranslator()
    {
        $translator = new Translator('nl');
        $translator->addLoader('array', new ArrayLoader());
        $this->assertNotEquals($translator, Date::getTranslator());

        Date::setTranslator($translator);
        $this->assertEquals($translator, Date::getTranslator());
    }

    public function testFallback()
    {
        Date::setLocale('xx');

        $date = Date::parse('-5 years');
        $this->assertSame('5 years ago', $date->ago());
    }

    public function testMultiplePluralForms()
    {
        Date::setLocale('hr');

        $date = Date::parse('-1 years');
        $this->assertSame("prije 1 godinu", $date->ago());

        $date = Date::parse('-2 years');
        $this->assertSame("prije 2 godine", $date->ago());

        $date = Date::parse('-3 years');
        $this->assertSame("prije 3 godine", $date->ago());

        $date = Date::parse('-5 years');
        $this->assertSame("prije 5 godina", $date->ago());
    }

    public function testCustomSuffix()
    {
        Date::setLocale('de');

        // If we use -1 month, we have the chance of it being converted to 4 weeks.
        $date = Date::parse('-40 days');
        $this->assertSame("vor 1 Monat", $date->ago());

        $date = Date::parse('-5 months');
        $this->assertSame("vor 5 Monaten", $date->ago());

        $date = Date::parse('-5 seconds');
        $this->assertSame("vor 5 Sekunden", $date->ago());
    }

    public function testTimespanTranslated()
    {
        Date::setLocale('nl');

        $date = new Date(1403619368);
        $date = $date->sub('-100 days -3 hours -20 minutes');

        $this->assertSame('3 maanden, 1 week, 1 dag, 3 uur, 20 minuten', $date->timespan(1403619368));
    }

    public function testParse()
    {
        Date::setLocale('nl');
        $date = Date::parse('1 januari 2015');
        $this->assertSame('2015-01-01', $date->format('Y-m-d'));

        Date::setLocale('nl');
        $date = Date::parse('zaterdag 21 maart 2015');
        $this->assertSame('2015-03-21', $date->format('Y-m-d'));
    }

    public function testCreateFromFormat()
    {
        Date::setLocale('nl');
        $date = Date::createFromFormat('d F Y', '1 januari 2015');
        $this->assertSame('2015-01-01', $date->format('Y-m-d'));

        Date::setLocale('nl');
        $date = Date::createFromFormat('D d F Y', 'zaterdag 21 maart 2015');
        $this->assertSame('2015-03-21', $date->format('Y-m-d'));
    }

    public function testAgoTranslated()
    {
        Date::setLocale('nl');

        $date = Date::parse('-5 years');
        $this->assertSame('5 jaar geleden', $date->ago());

        $date = Date::parse('-5 months');
        $this->assertSame('5 maanden geleden', $date->ago());

        $date = Date::parse('-32 days');
        $this->assertSame('1 maand geleden', $date->ago());

        $date = Date::parse('-4 days');
        $this->assertSame('4 dagen geleden', $date->ago());

        $date = Date::parse('-1 day');
        $this->assertSame('1 dag geleden', $date->ago());

        $date = Date::parse('-3 hours');
        $this->assertSame('3 uur geleden', $date->ago());

        $date = Date::parse('-1 hour');
        $this->assertSame('1 uur geleden', $date->ago());

        $date = Date::parse('-2 minutes');
        $this->assertSame('2 minuten geleden', $date->ago());

        $date = Date::parse('-1 minute');
        $this->assertSame('1 minuut geleden', $date->ago());

        $date = Date::parse('-50 second');
        $this->assertSame('50 seconden geleden', $date->ago());

        $date = Date::parse('-1 second');
        $this->assertSame('1 seconde geleden', $date->ago());

        $date = Date::parse('+5 days');
        $this->assertSame('5 dagen vanaf nu', $date->ago());

        $date = Date::parse('+5 days');
        $this->assertSame('5 dagen na', $date->ago(Date::now()));

        $date = Date::parse('-5 days');
        $this->assertSame('5 dagen voor', $date->ago(Date::now()));

        Date::setLocale('ru');

        $date = Date::parse('-21 hours');
        $this->assertSame('21 час до', $date->ago(Date::now()));

        $date = Date::parse('-11 hours');
        $this->assertSame('11 часов до', $date->ago(Date::now()));
    }

    public function testFormatTranslated()
    {
        Date::setLocale('nl');

        $date = new Date(1367186296);
        $this->assertSame('zondag 28 april 2013 21:58:16', $date->format('l j F Y H:i:s'));

        $date = new Date(1367186296);
        $this->assertSame('l 28 F 2013 21:58:16', $date->format('\l j \F Y H:i:s'));

        $date = new Date(1367186296);
        $this->assertSame('zo 28 apr 2013 21:58:16', $date->format('D j M Y H:i:s'));
    }

    public function testFormatDeclensions()
    {
        Date::setLocale('ru');

        $date = new Date('10 march 2015');
        $this->assertSame('март 2015', $date->format('F Y'));

        $date = new Date('10 march 2015');
        $this->assertSame('10 мартa 2015', $date->format('j F Y'));
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
