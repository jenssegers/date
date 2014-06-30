<?php

use Jenssegers\Date\Date;

class TranslationTest extends \PHPUnit_Framework_TestCase {

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
            'from now',
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
                $this->assertTrue(isset($translations[$item]), "Language: $language");
            }
        }
    }

    public function testStrftimeTranslation()
    {
        $skip = array('pt');
        $lowercase = array('fi', 'fr', 'it');

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
            if (in_array($language, $skip)) continue;
            $locale = $language . '_' . strtoupper($language) . '.utf8';

            foreach ($months as $month)
            {
                $date = new Date("1 $month");
                $date->setLocale($language);

                // Check if locale is available.
                if (setlocale(LC_ALL, $locale))
                {
                    $translated = strftime('%B', $date->getTimestamp());

                    if (in_array($language, $lowercase))
                    {
                        $this->assertEquals(strtolower($translated), strtolower($date->format('F')), "Language: $language");
                    }
                    else
                    {
                        $this->assertEquals($translated, $date->format('F'), "Language: $language");
                    }
                }
            }

            foreach ($days as $day)
            {
                $date = new Date($day);
                $date->setLocale($language);

                // Check if locale is available.
                if (setlocale(LC_ALL, $locale))
                {
                    $translated = strftime('%A', $date->getTimestamp());

                    if (in_array($language, $lowercase))
                    {
                        $this->assertEquals(strtolower($translated), strtolower($date->format('l')), "Language: $language");
                    }
                    else
                    {
                        $this->assertEquals($translated, $date->format('l'), "Language: $language");
                    }
                }
            }
        }
    }

}
