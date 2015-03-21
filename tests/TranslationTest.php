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
        $this->assertTrue($translator->has('january'));
        $this->assertEquals('January', $translator->get('january'));

        $translator->setLocale('nl');
        $this->assertTrue($translator->has('january'));
        $this->assertEquals('januari', $translator->get('january'));
    }

    public function testUnknownTranslation()
    {
        $translator = new Translator;
        $this->assertFalse($translator->has('test'));
        $this->assertEquals('test', $translator->get('test'));
    }

    public function testChoiceTranslation()
    {
        $translator = new Translator;
        $this->assertEquals('1 month', $translator->choice('month', 1));
        $this->assertEquals('2 months', $translator->choice('month', 2));
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

        // If we use -1 month, we have the chance of it being converted to 4 weeks.
        $date = Date::parse('-40 days');
        $this->assertSame("vor 1 Monat", $date->ago());

        $date = Date::parse('-5 months');
        $this->assertSame("vor 5 Monaten", $date->ago());

        $date = Date::parse('-5 seconds');
        $this->assertSame("vor 5 Sekunden", $date->ago());
    }

    public function testGetAllLines()
    {
        $translator = new Translator;
        $translator->setLocale('nl');

        $lines = $translator->getAllLines();
        $this->assertTrue(is_array($lines));
        $this->assertEquals('1 maand|:count maanden', $lines['month']);
    }

}
