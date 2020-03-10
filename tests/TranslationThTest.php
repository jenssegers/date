<?php

namespace Tests\Jenssegers;

use Jenssegers\Date\Date;

class TranslationThTest extends TestCaseBase
{
    const LOCALE = 'th';

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

        $date = Date::now()->subMonthsNoOverflow(6);
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
        $this->assertSame('อีก 21 ชั่วโมง', $date->ago());

        $date = Date::parse('+5 days');
        $this->assertSame('อีก 5 วัน', $date->ago());

        $date = Date::parse('+3 weeks');
        $this->assertSame('อีก 3 สัปดาห์', $date->ago());

        $date = Date::parse('+6 months');
        $this->assertSame('อีก 6 เดือน', $date->ago());

        $date = Date::parse('+10 years');
        $this->assertSame('อีก 10 ปี', $date->ago());
    }
}
