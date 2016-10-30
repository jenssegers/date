<?php

use Jenssegers\Date\Date;
use Symfony\Component\Translation\MessageSelector;

class AutomaticTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->languages = array_slice(scandir('src/Lang'), 2);
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
            'december',
        );

        $selector = new MessageSelector;

        foreach ($this->languages as $language) {
            $language = str_replace('.php', '', $language);
            $translations = include "src/Lang/$language.php";

            foreach ($months as $month) {
                $date = new Date("1 $month");
                $date->setLocale($language);

                // Full
                $translation = $selector->choose($translations[$month], 0, $language);
                $this->assertTrue(isset($translation));
                $this->assertEquals($translation, $date->format('F'), "Language: $language");

                // Short
                $monthShortEnglish = mb_substr($month, 0, 3);
                if (isset($translations[$monthShortEnglish])) {
                    $this->assertEquals($translations[$monthShortEnglish], $date->format('M'), "Language: $language");
                } else {
                    $this->assertEquals(mb_substr($translation, 0, 3), $date->format('M'), "Language: $language");
                }
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
            'sunday',
        );

        foreach ($this->languages as $language) {
            $language = str_replace('.php', '', $language);
            $translations = include "src/Lang/$language.php";

            foreach ($days as $day) {
                $date = new Date($day);
                $date->setLocale($language);

                // Full
                $this->assertTrue(isset($translations[$day]));
                $this->assertEquals($translations[$day], $date->format('l'), "Language: $language");

                // Short
                $dayShortEnglish = mb_substr($day, 0, 3);
                if (isset($translations[$dayShortEnglish])) {
                    $this->assertEquals($translations[$dayShortEnglish], $date->format('D'), "Language: $language");
                } else {
                    $this->assertEquals(mb_substr($translations[$day], 0, 3), $date->format('D'), "Language: $language");
                }
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
            'second',
        );

        foreach ($this->languages as $language) {
            $language = str_replace('.php', '', $language);
            $translations = include "src/Lang/$language.php";

            foreach ($items as $item) {
                $this->assertTrue(isset($translations[$item]), "Language: $language >> $item");

                if (! $translations[$item]) {
                    echo "\nWARNING! '$item' not set for language $language";
                    continue;
                }

                if (in_array($item, array('ago', 'from_now', 'after', 'before'))) {
                    $this->assertContains(':time', $translations[$item], "Language: $language");
                } else {
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
            'second',
        );

        foreach ($this->languages as $language) {
            $language = str_replace('.php', '', $language);
            $translations = include "src/Lang/$language.php";

            $translator = Date::getTranslator();
            $translator->setLocale($language);

            foreach ($items as $item) {
                $this->assertTrue(isset($translations[$item]), "Language: $language >> $item");

                if (! $translations[$item]) {
                    echo "\nWARNING! '$item' not set for language $language\n";
                    continue;
                }

                for ($i = 0; $i <= 60; $i++) {
                    if (in_array($item, array('ago', 'from_now', 'after', 'before'))) {
                        $translation = $translator->transChoice($item, $i, array(':time' => $i));
                        $this->assertNotNull($translation, "Language: $language ($i)");
                        $this->assertNotContains(':time', $translation, "Language: $language ($i)");
                    } else {
                        $translation = $translator->transChoice($item, $i, array(':count' => $i));
                        $this->assertNotNull($translation, "Language: $language ($i)");
                        $this->assertNotContains(':count', $translation, "Language: $language ($i)");
                    }
                }
            }
        }
    }
}
