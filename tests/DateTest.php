<?php 

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
		$this->assertEquals('2013-01-31', $date->format('date'));

		$date = Date::forgeFromDate(2013, 1, 31);
		$this->assertEquals('2013-01-31', $date->format('date'));
	}

	public function testDateIsCreatedFromTime()
	{
		$date = Date::makeFromTime(20, null, null);
		$this->assertEquals('20:00:00', $date->getTime());

		$date = Date::makeFromTime(-12, null, 120);
		$this->assertEquals('12:02:00', $date->getTime());

		$date = Date::makeFromTime(12, 30, 125);
		$this->assertEquals('12:32:05', $date->getTime());
	}

	public function testDateIsCreatedFromDateTime()
	{
		$date = Date::make(1367186296);
		$this->assertEquals('2013-04-28 21:58:16', $date->getDateTime());
	}

	public function testDateIsCreatedFromTimestamp()
	{
		$date = Date::makeFromDateTime(2013, 1, 31, 8, null, null);
		$this->assertEquals('2013-01-31 08:00:00', $date->getDateTime());

		$date = Date::makeFromDateTime(2013, 1, 31, -12, null, null);
		$this->assertEquals('2013-01-30 12:00:00', $date->getDateTime());
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
		$this->assertEquals(time(), $date->getTimestamp());

		date_default_timezone_set('Europe/Brussels');

		$date = new Date(null, new DateTimeZone('Europe/Paris'));
		date_default_timezone_set('Europe/Paris');
		$this->assertEquals(time(), $date->getTimestamp());
	}

	public function testDateIsCreatedWithCustomTimeString()
	{
		$date = new Date('31 January 1991');
		$this->assertEquals('31/01/1991', $date->format('d/m/Y'));

		$date = new Date('+1 day');
		$this->assertEquals(time() + 86400, $date->getTimestamp());

		$date = new Date('-1 day');
		$this->assertEquals(time() - 86400, $date->getTimestamp());
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
		$this->assertEquals('1991-01-31 00:00:00', $date);
	}

	public function testFormat()
	{
		$date = new Date('31 January 1991 12:00:30');

		$this->assertEquals('1991-01-31', $date->format('Y-m-d'));
		$this->assertEquals('12:00:30', $date->format('H:i:s'));
		$this->assertEquals('January', $date->format('F'));

		$this->assertEquals('1991-01-31 12:00:30', $date->format('datetime'));
		$this->assertEquals('1991-01-31', $date->format('date'));
		$this->assertEquals('12:00:30', $date->format('time'));
	}

	public function testGetCalls()
	{
		$date = Date::makeFromDate(2013, 1, 31);
		$this->assertEquals(2013, $date->getYear());
		$this->assertEquals(1, $date->getMonth());
		$this->assertEquals(31, $date->getDay());
		$this->assertEquals(30, $date->getDayOfYear());
		$this->assertEquals(31, $date->getDaysInMonth());
		$this->assertEquals("Thursday", $date->getDayOfWeek());

		$date = Date::makeFromTime(12, 0, 30);
		$this->assertEquals(12, $date->getHour());
		$this->assertEquals(0, $date->getMinutes());
		$this->assertEquals(30, $date->getSeconds());

		$date = Date::make('31 January 1991 12:00:30');
		$this->assertEquals('1991-01-31 12:00:30', $date->getDateTime());
		$this->assertEquals('1991-01-31', $date->getDate());
		$this->assertEquals('12:00:30', $date->getTime());
	}

	public function testGet()
	{
		$date = Date::makeFromDate(2013, 1, 31);
		$this->assertEquals(2013, $date->year);
		$this->assertEquals(1, $date->month);
		$this->assertEquals(31, $date->day);

		$date = Date::makeFromTime(12, 0, 30);
		$this->assertEquals(12, $date->hour);
		$this->assertEquals(12, $date->hours);
		$this->assertEquals(0, $date->minute);
		$this->assertEquals(0, $date->minutes);
		$this->assertEquals(30, $date->second);
		$this->assertEquals(30, $date->seconds);

		$date = Date::make('31 January 1991 12:00:30');
		$this->assertEquals('1991-01-31 12:00:30', $date->dateTime);
		$this->assertEquals('1991-01-31', $date->date);
		$this->assertEquals('12:00:30', $date->time);
	}

	public function testSetCalls()
	{
		$date = Date::now();
		$this->assertEquals(2013, $date->setYear(2013)->year);
		$this->assertEquals(1, $date->setMonth(1)->month);
		$this->assertEquals(31, $date->setDay(31)->day);

		$this->assertEquals(12, $date->setHour(12)->hours);
		$this->assertEquals(0, $date->setMinutes(0)->minutes);
		$this->assertEquals(30, $date->setSeconds(30)->seconds);

		$this->assertEquals('2013-01-31 12:00:30', $date->getDateTime());
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

		$this->assertEquals(2013, $date->year);
		$this->assertEquals(1, $date->month);
		$this->assertEquals(31, $date->day);

		$this->assertEquals(12, $date->hours);
		$this->assertEquals(0, $date->minutes);
		$this->assertEquals(30, $date->seconds);

		$this->assertEquals('2013-01-31 12:00:30', $date->getDateTime());
	}

	public function testManipulation()
	{
		$now = Date::now();

		$this->assertEquals(86400, Date::now()->add('1 day')->getTimestamp() - Date::now()->getTimestamp());
		$this->assertEquals(4*86400, Date::now()->add('4 day')->getTimestamp() - Date::now()->getTimestamp());

		$this->assertEquals(-86400, Date::now()->sub('1 day')->getTimestamp() - Date::now()->getTimestamp());
		$this->assertEquals(-4*86400, Date::now()->sub('4 day')->getTimestamp() - Date::now()->getTimestamp());

		$this->assertEquals(10*86400, Date::now()->add('P10D')->getTimestamp() - Date::now()->getTimestamp());
		$this->assertEquals(100*86400, Date::now()->add('P100D')->getTimestamp() - Date::now()->getTimestamp());
	}

	public function testAgo()
	{
		$date = Date::make('-5 months');
		$this->assertEquals("5 months ago", $date->ago());

		$date = Date::make('-32 days');
		$this->assertEquals("1 month ago", $date->ago());

		$date = Date::make('-4 days');
		$this->assertEquals("4 days ago", $date->ago());

		$date = Date::make('-1 day');
		$this->assertEquals("1 day ago", $date->ago());

		$date = Date::make('-3 hours');
		$this->assertEquals("3 hours ago", $date->ago());

		$date = Date::make('-1 hour');
		$this->assertEquals("1 hour ago", $date->ago());

		$date = Date::make('-2 minutes');
		$this->assertEquals("2 minutes ago", $date->ago());

		$date = Date::make('-1 minute');
		$this->assertEquals("1 minute ago", $date->ago());

		$date = Date::make('-50 second');
		$this->assertEquals("50 seconds ago", $date->ago());

		$date = Date::make('-1 second');
		$this->assertEquals("1 second ago", $date->ago());

		$date = Date::make('+5 days');
		$this->assertEquals("5 days from now", $date->ago());
	}

	public function testTimespan()
	{
		$date = Date::make('-5 months -15 days -3 hours -42 minutes');
		$this->assertEquals("0 years, 5 months, 2 weeks, 1 day, 3 hours, 42 minutes, 0 seconds", $date->timespan());
	}

}