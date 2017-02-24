<?php

use Jenssegers\Date\Date;
use PHPUnit\Framework\TestCase;

class TranslationThTest extends TestCase
{
    public function setUp()
    {
        date_default_timezone_set('UTC');
        Date::setLocale('th');
    }

    public function testTimespanTranslated()
    {
        $date = new Date(1403619368);
        $date = $date->sub('-100 days -3 hours -20 minutes');

        $this->assertSame('3 เดือน, 1 สัปดาห์, 1 วัน, 3 ชั่วโมง, 20 นาที', $date->timespan(1403619368));
    }

    public function testCreateFromFormat()
    {
        $date = Date::createFromFormat('d F Y', '1 มกราคม 2015');
        $this->assertSame('2015-01-01', $date->format('Y-m-d'));

        $date = Date::createFromFormat('D d F Y', 'เสาร์ 21 มีนาคม 2015');
        $this->assertSame('2015-03-21', $date->format('Y-m-d'));
    }

    public function testAgoTranslated()
    {
        $date = Date::parse('-21 hours');
        $this->assertSame('21 ชั่วโมงที่แล้ว', $date->ago());

        $date = Date::parse('-5 days');
        $this->assertSame('5 วันที่แล้ว', $date->ago());

        $date = Date::parse('-3 weeks');
        $this->assertSame('3 สัปดาห์ที่แล้ว', $date->ago());

        $date = Date::parse('-6 months');
        $this->assertSame('6 เดือนที่แล้ว', $date->ago());

        $date = Date::parse('-10 years');
        $this->assertSame('10 ปีที่แล้ว', $date->ago());
    }

    public function testFormatDeclensions()
    {
        $date = new Date('10 march 2015');
        $this->assertSame('มีนาคม 2015', $date->format('F Y'));

        $date = new Date('10 march 2015');
        $this->assertSame('10 มีนาคม 2015', $date->format('j F Y'));
    }

    public function testAfterTranslated()
    {
        $date = Date::parse('+21 hours');
        $this->assertSame('21 ชั่วโมงจากนี้', $date->ago());

        $date = Date::parse('+5 days');
        $this->assertSame('5 วันจากนี้', $date->ago());

        $date = Date::parse('+3 weeks');
        $this->assertSame('3 สัปดาห์จากนี้', $date->ago());

        $date = Date::parse('+6 months');
        $this->assertSame('6 เดือนจากนี้', $date->ago());

        $date = Date::parse('+10 years');
        $this->assertSame('10 ปีจากนี้', $date->ago());
    }
}
