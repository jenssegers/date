<?php

use Jenssegers\Date\Date;
use Jenssegers\Date\Translator;
use Symfony\Component\Translation\MessageSelector;

class AutomaticTest extends PHPUnit_Framework_TestCase {

    public function setUp()
    {
        $this->languages = array_slice(scandir('src/lang'), 2);
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

    public function testTranslatesCounts()
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
            if (in_array($language, array('ar')))
            {
                echo "\nWARNING! Not running automatic test for $language\n";
                continue;
            }

            $translations = include "src/lang/$language/date.php";

            $translator = Date::getTranslator();
            $translator->setLocale($language);

            foreach ($items as $item)
            {
                $this->assertTrue(isset($translations[$item]), "Language: $language >> $item");

                if ( ! $translations[$item])
                {
                    echo "\nWARNING! '$item' not set for language $language\n";
                    continue;
                }

                for ($i = 0; $i <= 60; $i++)
                {
                    if (in_array($item, array('ago', 'from_now', 'after', 'before')))
                    {
                        $translation = $translator->choice("date::date.$item", $i, array('time' => $i));
                        $this->assertNotNull($translation, "Language: $language ($i)");
                        $this->assertNotContains(':time', $translation, "Language: $language ($i)");
                    }
                    else
                    {
                        $translation = $translator->choice("date::date.$item", $i);
                        $this->assertNotNull($translation, "Language: $language ($i)");
                        $this->assertNotContains(':count', $translation, "Language: $language ($i)");
                    }
                }
            }
        }
    }

}
