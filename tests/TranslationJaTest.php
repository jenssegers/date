<?php

use Jenssegers\Date\Date;
use PHPUnit\Framework\TestCase;

/**
 * Class TranslationJaTest
 */
class TranslationJaTest extends TestCase
{
    public function setUp()
    {
        date_default_timezone_set('UTC');
        Date::setLocale('ja');
    }

    /**
     * @test
     */
    public function it_can_translate_month()
    {
        $jan = Date::createFromFormat('m', '01');
        $feb = Date::createFromFormat('m-d', '02-02'); // ('m', '02') overshoots to next month.
        $mar = Date::createFromFormat('m', '03');
        $apr = Date::createFromFormat('m', '04');
        $may = Date::createFromFormat('m', '05');
        $jun = Date::createFromFormat('m', '06');
        $jul = Date::createFromFormat('m', '07');
        $aug = Date::createFromFormat('m', '08');
        $sep = Date::createFromFormat('m', '09');
        $oct = Date::createFromFormat('m', '10');
        $nov = Date::createFromFormat('m', '11');
        $dec = Date::createFromFormat('m', '12');

        $this->assertEquals('1月', $jan->format('F'));
        $this->assertEquals('2月', $feb->format('F'));
        $this->assertEquals('3月', $mar->format('F'));
        $this->assertEquals('4月', $apr->format('F'));
        $this->assertEquals('5月', $may->format('F'));
        $this->assertEquals('6月', $jun->format('F'));
        $this->assertEquals('7月', $jul->format('F'));
        $this->assertEquals('8月', $aug->format('F'));
        $this->assertEquals('9月', $sep->format('F'));
        $this->assertEquals('10月', $oct->format('F'));
        $this->assertEquals('11月', $nov->format('F'));
        $this->assertEquals('12月', $dec->format('F'));
    }

    /**
     * @test
     */
    public function it_can_translate_weekdays()
    {
        $mon = Date::parse('next monday');
        $tue = Date::parse('next tuesday');
        $wed = Date::parse('next wednesday');
        $thu = Date::parse('next thursday');
        $fri = Date::parse('next friday');
        $sat = Date::parse('next saturday');
        $sun = Date::parse('next sunday');

        $this->assertEquals('月曜日', $mon->format('l'));
        $this->assertEquals('火曜日', $tue->format('l'));
        $this->assertEquals('水曜日', $wed->format('l'));
        $this->assertEquals('木曜日', $thu->format('l'));
        $this->assertEquals('金曜日', $fri->format('l'));
        $this->assertEquals('土曜日', $sat->format('l'));
        $this->assertEquals('日曜日', $sun->format('l'));
    }

    /**
     * @test
     */
    public function it_can_translate_weekdays_short_form()
    {
        $mon = Date::parse('next monday');
        $tue = Date::parse('next tuesday');
        $wed = Date::parse('next wednesday');
        $thu = Date::parse('next thursday');
        $fri = Date::parse('next friday');
        $sat = Date::parse('next saturday');
        $sun = Date::parse('next sunday');

        $this->assertEquals('月', $mon->format('D'));
        $this->assertEquals('火', $tue->format('D'));
        $this->assertEquals('水', $wed->format('D'));
        $this->assertEquals('木', $thu->format('D'));
        $this->assertEquals('金', $fri->format('D'));
        $this->assertEquals('土', $sat->format('D'));
        $this->assertEquals('日', $sun->format('D'));
    }

    /**
     * @test
     */
    public function it_can_translate_seconds_ago()
    {
        $oneSecondAgo = Date::parse('-1 second');
        $fiveSecondsAgo = Date::parse('-5 seconds');

        $this->assertEquals('1 秒 前', $oneSecondAgo->ago());
        $this->assertEquals('5 秒 前', $fiveSecondsAgo->ago());
    }

    /**
     * @test
     */
    public function it_can_translate_minutes_ago()
    {
        $oneMinuteAgo = Date::parse('-1 minute');
        $fiveMinutesAgo = Date::parse('-5 minutes');

        $this->assertEquals('1 分 前', $oneMinuteAgo->ago());
        $this->assertEquals('5 分 前', $fiveMinutesAgo->ago());
    }

    /**
     * @test
     */
    public function it_can_translate_hours_ago()
    {
        $oneHourAgo = Date::parse('-1 hour');
        $fiveHoursAgo = Date::parse('-5 hours');

        $this->assertEquals('1 時間 前', $oneHourAgo->ago());
        $this->assertEquals('5 時間 前', $fiveHoursAgo->ago());
    }

    /**
     * @test
     */
    public function it_can_translate_days_ago()
    {
        $oneDayAgo = Date::parse('-1 day');
        $threeDaysAgo = Date::parse('-3 days');

        $this->assertEquals('1 日 前', $oneDayAgo->ago());
        $this->assertEquals('3 日 前', $threeDaysAgo->ago());
    }

    /**
     * @test
     */
    public function it_can_translate_weeks_ago()
    {
        $oneWeekAgo = Date::parse('-1 week');
        $threeWeeksAgo = Date::parse('-3 weeks');

        $this->assertEquals('1 週間 前', $oneWeekAgo->ago());
        $this->assertEquals('3 週間 前', $threeWeeksAgo->ago());
    }

    /**
     * @test
     */
    public function it_can_translate_months_ago()
    {
        $oneMonthAgo = Date::parse('-1 month');
        $twoMonthsAgo = Date::parse('-2 months');

        $this->assertEquals('1 ヶ月 前', $oneMonthAgo->ago());
        $this->assertEquals('2 ヶ月 前', $twoMonthsAgo->ago());
    }

    /**
     * @test
     */
    public function it_can_translate_years_ago()
    {
        $oneYearAgo = Date::parse('-1 year');
        $towYearsAgo = Date::parse('-2 years');

        $this->assertEquals('1 年 前', $oneYearAgo->ago());
        $this->assertEquals('2 年 前', $towYearsAgo->ago());
    }

    /**
     * @test
     */
    public function it_can_translate_seconds_from_now()
    {
        $oneSecondFromNow = Date::parse('1 second');
        $fiveSecondsFromNow = Date::parse('5 seconds');

        $this->assertEquals('今から 1 秒', $oneSecondFromNow->diffForHumans());
        $this->assertEquals('今から 5 秒', $fiveSecondsFromNow->diffForHumans());
    }

    /**
     * @test
     */
    public function it_can_translate_minutes_from_now()
    {
        $oneMinuteFromNow = Date::parse('1 minute');
        $fiveMinutesFromNow = Date::parse('5 minutes');

        $this->assertEquals('今から 1 分', $oneMinuteFromNow->diffForHumans());
        $this->assertEquals('今から 5 分', $fiveMinutesFromNow->diffForHumans());
    }

    /**
     * @test
     */
    public function it_can_translate_hours_from_now()
    {
        $oneHourFromNow = Date::parse('1 hour');
        $fiveHoursFromNow = Date::parse('5 hours');

        $this->assertEquals('今から 1 時間', $oneHourFromNow->diffForHumans());
        $this->assertEquals('今から 5 時間', $fiveHoursFromNow->diffForHumans());
    }

    /**
     * @test
     */
    public function it_can_translate_days_from_now()
    {
        $oneDayFromNow = Date::parse('1 day');
        $threeDaysFromNow = Date::parse('3 days');

        $this->assertEquals('今から 1 日', $oneDayFromNow->diffForHumans());
        $this->assertEquals('今から 3 日', $threeDaysFromNow->diffForHumans());
    }

    /**
     * @test
     */
    public function it_can_translate_weeks_from_now()
    {
        $oneWeekFromNow = Date::parse('1 week');
        $threeWeeksFromNow = Date::parse('3 weeks');

        $this->assertEquals('今から 1 週間', $oneWeekFromNow->diffForHumans());
        $this->assertEquals('今から 3 週間', $threeWeeksFromNow->diffForHumans());
    }

    /**
     * @test
     */
    public function it_can_translate_months_from_now()
    {
        $oneMonthFromNow = Date::parse('1 month');
        $twoMonthsFromNow = Date::parse('2 months');

        $this->assertEquals('今から 1 ヶ月', $oneMonthFromNow->diffForHumans());
        $this->assertEquals('今から 2 ヶ月', $twoMonthsFromNow->diffForHumans());
    }

    /**
     * @test
     */
    public function it_can_translate_years_from_now()
    {
        $oneYearFromNow = Date::parse('1 year');
        $towYearsFromNow = Date::parse('2 years');

        $this->assertEquals('今から 1 年', $oneYearFromNow->diffForHumans());
        $this->assertEquals('今から 2 年', $towYearsFromNow->diffForHumans());
    }
}
