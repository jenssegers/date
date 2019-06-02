<?php

namespace Tests\Jenssegers;

use Jenssegers\Date\Date;

class TranslationElTest extends TestCaseBase
{
    const LOCALE = 'el';

    public function testTimespanTranslated()
    {
        $date = new Date(1403619368);
        $date = $date->sub('-100 days -3 hours -20 minutes');

        $this->assertSame('3 μήνες, 1 εβδομάδα, 1 μέρα, 3 ώρες, 20 λεπτά', $date->timespan(1403619368));
    }

    public function testCreateFromFormat()
    {
        $date = Date::createFromFormat('d F Y', '1 Ιανουαρίου 2015');
        $this->assertSame('2015-01-01', $date->format('Y-m-d'));

        $date = Date::createFromFormat('D d F Y', 'Σάββατο 21 Μαρτίου 2015');
        $this->assertSame('2015-03-21', $date->format('Y-m-d'));
    }

    public function testAgoTranslated()
    {
        $date = Date::parse('-21 hours');
        $this->assertSame('21 ώρες πριν', $date->ago());

        $date = Date::parse('-5 days');
        $this->assertSame('5 μέρες πριν', $date->ago());

        $date = Date::parse('-3 weeks');
        $this->assertSame('3 εβδομάδες πριν', $date->ago());

        $date = Date::parse('-6 months');
        $this->assertSame('6 μήνες πριν', $date->ago());

        $date = Date::parse('-10 years');
        $this->assertSame('10 χρόνια πριν', $date->ago());
    }

    public function testFormatDeclensions()
    {
        $date = new Date('10 march 2015');
        $this->assertSame('Μάρτιος 2015', $date->format('F Y'));

        $date = new Date('10 march 2015');
        $this->assertSame('10 Μαρτίου 2015', $date->format('j F Y'));
    }

    public function testFormatShortNotation()
    {
        $date = new Date('10 january 2015');
        $this->assertSame('10 Ιαν 2015', $date->format('j M Y'));

        $date = new Date('10 february 2015');
        $this->assertSame('10 Φεβ 2015', $date->format('j M Y'));

        $date = new Date('10 march 2015');
        $this->assertSame('10 Μαρ 2015', $date->format('j M Y'));

        $date = new Date('10 april 2015');
        $this->assertSame('10 Απρ 2015', $date->format('j M Y'));

        $date = new Date('10 may 2015');
        $this->assertSame('10 Μαϊ 2015', $date->format('j M Y'));

        $date = new Date('10 june 2015');
        $this->assertSame('10 Ιουν 2015', $date->format('j M Y'));

        $date = new Date('10 july 2015');
        $this->assertSame('10 Ιουλ 2015', $date->format('j M Y'));

        $date = new Date('10 august 2015');
        $this->assertSame('10 Αυγ 2015', $date->format('j M Y'));

        $date = new Date('10 september 2015');
        $this->assertSame('10 Σεπ 2015', $date->format('j M Y'));

        $date = new Date('10 october 2015');
        $this->assertSame('10 Οκτ 2015', $date->format('j M Y'));

        $date = new Date('10 november 2015');
        $this->assertSame('10 Νοε 2015', $date->format('j M Y'));

        $date = new Date('10 december 2015');
        $this->assertSame('10 Δεκ 2015', $date->format('j M Y'));
    }

    public function testAfterTranslated()
    {
        $date = Date::parse('+21 hours');
        $this->assertSame('σε 21 ώρες', $date->ago());

        $date = Date::parse('+5 days');
        $this->assertSame('σε 5 μέρες', $date->ago());

        $date = Date::parse('+3 weeks');
        $this->assertSame('σε 3 εβδομάδες', $date->ago());

        $date = Date::parse('+6 months');
        $this->assertSame('σε 6 μήνες', $date->ago());

        $date = Date::parse('+10 years');
        $this->assertSame('σε 10 χρόνια', $date->ago());
    }
}
