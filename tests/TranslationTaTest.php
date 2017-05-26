<?php

use Jenssegers\Date\Date;
use PHPUnit\Framework\TestCase;

class TranslationTaTest extends TestCase
{

	/**
	 * @return void
	 */
	public function setUp()
	{
		date_default_timezone_set('UTC');
		Date::setLocale('ta');
	}

	/** @test */
	public function it_translates_month()
	{

		$jan = Date::createFromFormat('m', '01');
		$feb = Date::createFromFormat('m', '02');
		$mar = Date::createFromFormat('m', '03');
		$apr = Date::createFromFormat('m', '04');
		$may = Date::createFromFormat('m', '05');
		$jun = Date::createFromFormat('m', '06');
		$jul = Date::createFromFormat('m', '07');
		$aug = Date::createFromFormat('m', '08');
		$sep = Date::createFromFormat('m', '09');
		$okt = Date::createFromFormat('m', '10');
		$nov = Date::createFromFormat('m', '11');
		$dez = Date::createFromFormat('m', '12');

		$this->assertEquals('தை', $jan->format('F'));
		$this->assertEquals('மாசி', $feb->format('F'));
		$this->assertEquals('பங்குனி', $mar->format('F'));
		$this->assertEquals('சித்திரை', $apr->format('F'));
		$this->assertEquals('வைகாசி', $may->format('F'));
		$this->assertEquals('ஆனி', $jun->format('F'));
		$this->assertEquals('ஆடி', $jul->format('F'));
		$this->assertEquals('ஆவணி', $aug->format('F'));
		$this->assertEquals('புரட்டாசி', $sep->format('F'));
		$this->assertEquals('ஐப்பசி', $okt->format('F'));
		$this->assertEquals('கார்த்திகை', $nov->format('F'));
		$this->assertEquals('மார்கழி', $dez->format('F'));

	}

	/** @test */
	public function it_translates_weekdays ()
	{
		$mon = Date::parse('next monday');
		$tue = Date::parse('next tuesday');
		$wed = Date::parse('next wednesday');
		$thu = Date::parse('next thursday');
		$fri = Date::parse('next friday');
		$sat = Date::parse('next saturday');
		$sun = Date::parse('next sunday');

		$this->assertEquals('திங்கட்கிழமை', $mon->format('l'));
		$this->assertEquals('செவ்வாய்க்கிழமை', $tue->format('l'));
		$this->assertEquals('புதன்கிழமை', $wed->format('l'));
		$this->assertEquals('வியாழக்கிழமை', $thu->format('l'));
		$this->assertEquals('வெள்ளிக்கிழமை', $fri->format('l'));
		$this->assertEquals('சனிக்கிழமை', $sat->format('l'));
		$this->assertEquals('ஞாயிற்றுக்கிழமை', $sun->format('l'));

	}

	/** @test */
	public function it_translates_weekdays_shortform ()
	{
		$mon = Date::parse('next monday');
		$tue = Date::parse('next tuesday');
		$wed = Date::parse('next wednesday');
		$thu = Date::parse('next thursday');
		$fri = Date::parse('next friday');
		$sat = Date::parse('next saturday');
		$sun = Date::parse('next sunday');

		$this->assertEquals('திங்கள்', $mon->format('D'));
		$this->assertEquals('செவ்வாய்', $tue->format('D'));
		$this->assertEquals('புதன்', $wed->format('D'));
		$this->assertEquals('வியாழன்', $thu->format('D'));
		$this->assertEquals('வெள்ளி', $fri->format('D'));
		$this->assertEquals('சனி', $sat->format('D'));
		$this->assertEquals('ஞாயிறு', $sun->format('D'));

	}



}
