<?php 

require "vendor/autoload.php";

use \Jenssegers\Date\Date;

class DateTest extends \PHPUnit_Framework_TestCase {

	protected $date;

	public function tearDown()
	{
		$this->date = null;
	}

	public function setUp()
	{
		date_default_timezone_set('Europe/Brussels');

		$this->date = new Date;
	}

	public function testDateIsCreatedFromNow()
	{
		$this->assertEquals(time(), $this->date->getTimestamp());
	}

	public function testDateIsCreatedFromStaticMethod()
	{
		$date = Date::make();
		$this->assertEquals(time(), $date->getTimestamp());

		$date = Date::make('now');
		$this->assertEquals(time(), $date->getTimestamp());

		$date = Date::now();
		$this->assertEquals(time(), $date->getTimestamp());

		$date = Date::forge();
		$this->assertEquals(time(), $date->getTimestamp());
	}

	public function testDateIsCreatedFromDate()
	{
		$date = Date::makeFromDate(2013, 1, 31);
		$this->assertSame('2013-01-31', $date->format('date'));

		$date = Date::forgeFromDate(2013, 1, 31);
		$this->assertSame('2013-01-31', $date->format('date'));
	}

	public function testDateIsCreatedFromTime()
	{
		$date = Date::makeFromTime(20, null, null);
		$this->assertSame('20:00:00', $date->getTime());

		$date = Date::makeFromTime(-12, null, 120);
		$this->assertSame('12:02:00', $date->getTime());

		$date = Date::makeFromTime(12, 30, 125);
		$this->assertSame('12:32:05', $date->getTime());
	}

	public function testDateIsCreatedFromDateTime()
	{
		$date = Date::make(1367186296);
		$this->assertSame('2013-04-28 21:58:16', $date->getDateTime());
	}

	public function testDateIsCreatedFromTimestamp()
	{
		$date = Date::makeFromDateTime(2013, 1, 31, 8, null, null);
		$this->assertSame('2013-01-31 08:00:00', $date->getDateTime());

		$date = Date::makeFromDateTime(2013, 1, 31, -12, null, null);
		$this->assertSame('2013-01-30 12:00:00', $date->getDateTime());
	}

	public function testDateIsCreatedWithTimeZone()
	{
		$timezone = new DateTimeZone('Europe/Brussels');
		$date = Date::make(null, $timezone);

		$this->assertEquals($date, Date::make(null, 'Europe/Brussels'));
	}

	public function testDateIsCreatedWithDifferentTimezone()
	{
		$date = new Date(null, 'Europe/Paris');
		date_default_timezone_set('Europe/Paris');
		$this->assertSame(time(), $date->getTimestamp());

		date_default_timezone_set('Europe/Brussels');

		$date = new Date(null, new DateTimeZone('Europe/Paris'));
		date_default_timezone_set('Europe/Paris');
		$this->assertSame(time(), $date->getTimestamp());
	}

	public function testDateIsCreatedWithCustomTimeString()
	{
		$date = new Date('31 January 1991');
		$this->assertSame('31/01/1991', $date->format('d/m/Y'));

		$date = new Date('+1 day');
		$this->assertSame(time() + 86400, $date->getTimestamp());

		$date = new Date('-1 day');
		$this->assertSame(time() - 86400, $date->getTimestamp());
	}

	/**
	 * @expectedException Exception
	 */
	public function testCannotCreateDateWithInvalidTimezone()
	{
		$date = new Date(null, 'Nowhere');
	}

	public function testToString()
	{
		$date = new Date('31 January 1991');
		$this->assertSame('1991-01-31 00:00:00', (string) $date);
	}

	public function testFormat()
	{
		$date = new Date('31 January 1991 12:00:30');

		$this->assertSame('1991-01-31', $date->format('Y-m-d'));
		$this->assertSame('12:00:30', $date->format('H:i:s'));
		$this->assertSame('January', $date->format('F'));

		$this->assertSame('1991-01-31 12:00:30', $date->format('datetime'));
		$this->assertSame('1991-01-31', $date->format('date'));
		$this->assertSame('12:00:30', $date->format('time'));
	}

	public function testGetCalls()
	{
		$date = Date::makeFromDate(2013, 1, 31);
		$this->assertSame(2013, $date->getYear());
		$this->assertSame(1, $date->getMonth());
		$this->assertSame(31, $date->getDay());
		$this->assertSame(30, $date->getDayOfYear());
		$this->assertSame(31, $date->getDaysInMonth());
		$this->assertSame(4, $date->getDayOfWeek());

		$date = Date::makeFromTime(12, 0, 30);
		$this->assertSame(12, $date->getHour());
		$this->assertSame(0, $date->getMinutes());
		$this->assertSame(30, $date->getSeconds());

		$date = Date::make('31 January 1991 12:00:30');
		$this->assertSame('1991-01-31 12:00:30', $date->getDateTime());
		$this->assertSame('1991-01-31', $date->getDate());
		$this->assertSame('12:00:30', $date->getTime());
		$this->assertSame(665319630, $date->getTimestamp());
		$this->assertSame(22, $date->getAge());

		$date = Date::make('+10 years');
		$this->assertSame(-10, $date->getAge());
	}

	public function testGet()
	{
		$date = Date::makeFromDate(2013, 1, 31);
		$this->assertSame(2013, $date->year);
		$this->assertSame(1, $date->month);
		$this->assertSame(31, $date->day);

		$date = Date::makeFromTime(12, 0, 30);
		$this->assertSame(12, $date->hour);
		$this->assertSame(12, $date->hours);
		$this->assertSame(0, $date->minute);
		$this->assertSame(0, $date->minutes);
		$this->assertSame(30, $date->second);
		$this->assertSame(30, $date->seconds);

		$date = Date::make('31 January 1991 12:00:30');
		$this->assertSame('1991-01-31 12:00:30', $date->dateTime);
		$this->assertSame('1991-01-31', $date->date);
		$this->assertSame('12:00:30', $date->time);
		$this->assertSame(665319630, $date->timestamp);
		$this->assertSame(22, $date->age);

		$date = Date::make('+10 years');
		$this->assertSame(-10, $date->age);
	}

	public function testSetCalls()
	{
		$date = Date::now();
		$this->assertSame(2013, $date->setYear(2013)->year);
		$this->assertSame(1, $date->setMonth(1)->month);
		$this->assertSame(31, $date->setDay(31)->day);

		$this->assertSame(12, $date->setHour(12)->hours);
		$this->assertSame(0, $date->setMinutes(0)->minutes);
		$this->assertSame(30, $date->setSeconds(30)->seconds);

		$this->assertSame('2013-01-31 12:00:30', $date->getDateTime());
	}

	public function testSet()
	{
		$date = Date::now();

		$date->year = 2013;
		$date->month = 1;
		$date->day = 31;

		$date->hour = 12;
		$date->minutes = 0;
		$date->seconds = 30;

		$this->assertSame(2013, $date->year);
		$this->assertSame(1, $date->month);
		$this->assertSame(31, $date->day);

		$this->assertSame(12, $date->hours);
		$this->assertSame(0, $date->minutes);
		$this->assertSame(30, $date->seconds);

		$this->assertSame('2013-01-31 12:00:30', $date->getDateTime());
	}

	public function testIsset()
	{
		$now = Date::now();

		$this->assertSame(true, isset($now->year));
		$this->assertSame(true, isset($now->month));
		$this->assertSame(true, isset($now->day));
		$this->assertSame(true, isset($now->hours));
		$this->assertSame(true, isset($now->minutes));
		$this->assertSame(true, isset($now->seconds));
		$this->assertSame(true, isset($now->age));
	}

	public function testManipulation()
	{
		$now = Date::now();

		$this->assertSame(86400, Date::now()->add('1 day')->getTimestamp() - Date::now()->getTimestamp());
		$this->assertSame(4*86400, Date::now()->add('4 day')->getTimestamp() - Date::now()->getTimestamp());

		$this->assertSame(-86400, Date::now()->sub('1 day')->getTimestamp() - Date::now()->getTimestamp());
		$this->assertSame(-4*86400, Date::now()->sub('4 day')->getTimestamp() - Date::now()->getTimestamp());

		$this->assertSame(10*86400, Date::now()->add('P10D')->getTimestamp() - Date::now()->getTimestamp());
		$this->assertSame(-10*86400, Date::now()->sub('P10D')->getTimestamp() - Date::now()->getTimestamp());
	}

	public function testAgo()
	{
		$date = Date::make('-5 months');
		$this->assertSame("5 months ago", $date->ago());

		$date = Date::make('-32 days');
		$this->assertSame("1 month ago", $date->ago());

		$date = Date::make('-4 days');
		$this->assertSame("4 days ago", $date->ago());

		$date = Date::make('-1 day');
		$this->assertSame("1 day ago", $date->ago());

		$date = Date::make('-3 hours');
		$this->assertSame("3 hours ago", $date->ago());

		$date = Date::make('-1 hour');
		$this->assertSame("1 hour ago", $date->ago());

		$date = Date::make('-2 minutes');
		$this->assertSame("2 minutes ago", $date->ago());

		$date = Date::make('-1 minute');
		$this->assertSame("1 minute ago", $date->ago());

		$date = Date::make('-50 second');
		$this->assertSame("50 seconds ago", $date->ago());

		$date = Date::make('-1 second');
		$this->assertSame("1 second ago", $date->ago());

		$date = Date::make('+5 days');
		$this->assertSame("5 days from now", $date->ago());
	}

	public function testAge()
	{
		$date = Date::make('31 January 1991 12:00:30');
		$this->assertSame(22, $date->age());

		$date = Date::make('+10 years');
		$this->assertSame(-10, $date->age());
	}

	public function testTimespan()
	{
		$date = Date::make('-100 days -3 hours -20 minutes');
		$this->assertSame("0 years, 3 months, 1 week, 2 days, 3 hours, 20 minutes, 0 seconds", $date->timespan());
	}

}