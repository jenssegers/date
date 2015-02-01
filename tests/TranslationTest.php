<?php

use Jenssegers\Date\Date;
use Jenssegers\Date\Translator;
use Symfony\Component\Translation\MessageSelector;

class TranslationTest extends PHPUnit_Framework_TestCase {

    public function setUp()
    {
        $this->languages = array_slice(scandir('src/lang'), 2);
    }

    public function testKnownTranslation()
    {
        $translator = new Translator;
        $this->assertTrue($translator->has('date::date.january'));
        $this->assertEquals('January', $translator->get('date::date.january'));
    }

    public function testUnknownTranslation()
    {
        $translator = new Translator;
        $this->assertFalse($translator->has('date::date.test'));
        $this->assertEquals('date::date.test', $translator->get('date::date.test'));
    }

    public function testChoiceTranslation()
    {
        $translator = new Translator;
        $this->assertEquals('1 month', $translator->choice('date::date.month', 1));
        $this->assertEquals('2 months', $translator->choice('date::date.month', 2));
    }

    public function testGetsAndSetsTranslator()
    {
        $translator = new Translator;
        $this->assertNotEquals($translator, Date::getTranslator());

        Date::setTranslator($translator);
        $this->assertEquals($translator, Date::getTranslator());
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

        $date = Date::parse('-1 month');
        $this->assertSame("vor 1 Monat", $date->ago());

        $date = Date::parse('-5 months');
        $this->assertSame("vor 5 Monaten", $date->ago());

        $date = Date::parse('-5 seconds');
        $this->assertSame("vor 5 Sekunden", $date->ago());
    }

    public function testTranslatesMonths()
    {
        $months = array(
            'january',
            'february',
            'march',
            'april',
            'may',
            'june',
            'july',
            'august',
            'september',
            'october',
            'november',
            'december'
        );

        foreach ($this->languages as $language)
        {
            $translations = include "src/lang/$language/date.php";

            foreach ($months as $month)
            {
                $date = new Date("1 $month");
                $date->setLocale($language);

                $this->assertTrue(isset($translations[$month]));
                $this->assertEquals($translations[$month], $date->format('F'), "Language: $language"); // Full
                $this->assertEquals(substr($translations[$month], 0 , 3), $date->format('M'), "Language: $language"); // Short
            }
        }
    }

    public function testTranslatesDays()
    {
        $days = array(
            'monday',
            'tuesday',
            'wednesday',
            'thursday',
            'friday',
            'saturday',
            'sunday'
        );

        foreach ($this->languages as $language)
        {
            $translations = include "src/lang/$language/date.php";

            foreach ($days as $day)
            {
                $date = new Date($day);
                $date->setLocale($language);

                $this->assertTrue(isset($translations[$day]));
                $this->assertEquals($translations[$day], $date->format('l'), "Language: $language"); // Full
                $this->assertEquals(substr($translations[$day], 0 , 3), $date->format('D'), "Language: $language"); // Short
            }
        }
    }

    public function testTranslatesDiffForHumans()
    {
        $items = array(
            'ago',
            'from_now',
            'after',
            'before',
            'year',
            'month',
            'week',
            'day',
            'hour',
            'minute',
            'second'
        );

        foreach ($this->languages as $language)
        {
            $translations = include "src/lang/$language/date.php";

            foreach ($items as $item)
            {
                $this->assertTrue(isset($translations[$item]), "Language: $language >> $item");

                if ( ! $translations[$item])
                {
                    echo "\nWARNING! '$item' not set for language $language";
                    continue;
                }

                if (in_array($item, array('ago', 'from_now', 'after', 'before')))
                {
                    $this->assertContains(':time', $translations[$item], "Language: $language");
                }
                else
                {
                    $this->assertContains(':count', $translations[$item], "Language: $language");
                }
            }
        }
    }

}
