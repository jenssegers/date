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
        $jan = Date::createFromFormat('m-d', '01-01');
        $feb = Date::createFromFormat('m-d', '02-01');
        $mar = Date::createFromFormat('m-d', '03-01');
        $apr = Date::createFromFormat('m-d', '04-01');
        $may = Date::createFromFormat('m-d', '05-01');
        $jun = Date::createFromFormat('m-d', '06-01');
        $jul = Date::createFromFormat('m-d', '07-01');
        $aug = Date::createFromFormat('m-d', '08-01');
        $sep = Date::createFromFormat('m-d', '09-01');
        $oct = Date::createFromFormat('m-d', '10-01');
        $nov = Date::createFromFormat('m-d', '11-01');
        $dec = Date::createFromFormat('m-d', '12-01');

        $this->assertEquals('தை', $jan->format('F'));
        $this->assertEquals('மாசி', $feb->format('F'));
        $this->assertEquals('பங்குனி', $mar->format('F'));
        $this->assertEquals('சித்திரை', $apr->format('F'));
        $this->assertEquals('வைகாசி', $may->format('F'));
        $this->assertEquals('ஆனி', $jun->format('F'));
        $this->assertEquals('ஆடி', $jul->format('F'));
        $this->assertEquals('ஆவணி', $aug->format('F'));
        $this->assertEquals('புரட்டாசி', $sep->format('F'));
        $this->assertEquals('ஐப்பசி', $oct->format('F'));
        $this->assertEquals('கார்த்திகை', $nov->format('F'));
        $this->assertEquals('மார்கழி', $dec->format('F'));
    }

    /** @test */
    public function it_translates_weekdays()
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
    public function it_translates_weekdays_shortform()
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

    /** @test */
    public function it_translates_ago()
    {
        $oneAgo = Date::parse('-1 second');
        $fiveAgo = Date::parse('-5 seconds');

        $this->assertEquals('1 நொடி முன்பு', $oneAgo->ago());
        $this->assertEquals('5 நொடிகல் முன்பு', $fiveAgo->ago());

        ///

        $oneAgo = Date::parse('-1 minute');
        $fiveAgo = Date::parse('-5 minutes');

        $this->assertEquals('1 நிமிடம் முன்பு', $oneAgo->ago());
        $this->assertEquals('5 நிமிடங்கள் முன்பு', $fiveAgo->ago());

        ///

        $oneAgo = Date::parse('-1 hour');
        $fiveAgo = Date::parse('-5 hours');

        $this->assertEquals('1 மணி நேரம் முன்பு', $oneAgo->ago());
        $this->assertEquals('5 மணி நேரம் முன்பு', $fiveAgo->ago());

        ///

        $oneAgo = Date::parse('-1 day');
        $fiveAgo = Date::parse('-5 days');

        $this->assertEquals('1 நாள் முன்பு', $oneAgo->ago());
        $this->assertEquals('5 நாட்களுக்கு முன்பு', $fiveAgo->ago());

        ///

        $oneAgo = Date::parse('-1 week');
        $fiveAgo = Date::parse('-3 weeks');

        $this->assertEquals('1 வாரத்திற்கு முன்பு', $oneAgo->ago());
        $this->assertEquals('3 வாரங்களுக்கு முன்பு', $fiveAgo->ago());

        ///

        $oneAgo = Date::parse('-1 month');
        $fiveAgo = Date::parse('-3 months');

        $this->assertEquals('1 மாதம் முன்பு', $oneAgo->ago());
        $this->assertEquals('3 மாதங்களுக்கு முன்பு', $fiveAgo->ago());

        ///

        $oneAgo = Date::parse('-1 year');
        $fiveAgo = Date::parse('-3 years');

        $this->assertEquals('1 ஆண்டு முன்பு', $oneAgo->ago());
        $this->assertEquals('3 ஆண்டுகளுக்கு முன்பு', $fiveAgo->ago());
    }

    /** @test */
    public function it_translates_from_now()
    {
        $oneAgo = Date::parse('1 second');
        $fiveAgo = Date::parse('5 seconds');

        $this->assertEquals('1 வினாடியில்', $oneAgo->ago());
        $this->assertEquals('5 வினாடிகளில்', $fiveAgo->ago());

        ///

        $oneAgo = Date::parse('1 minute');
        $fiveAgo = Date::parse('5 minutes');

        $this->assertEquals('1 நிமிடத்தில்', $oneAgo->ago());
        $this->assertEquals('5 நிமிடங்களில்', $fiveAgo->ago());

        ///

        $oneAgo = Date::parse('1 hour');
        $fiveAgo = Date::parse('5 hours');

        $this->assertEquals('1 மணி நேரத்தில்', $oneAgo->ago());
        $this->assertEquals('5 மணி நேரத்தில்', $fiveAgo->ago());

        ///

        $oneAgo = Date::parse('1 day');
        $fiveAgo = Date::parse('5 days');

        $this->assertEquals('1 நாளில்', $oneAgo->ago());
        $this->assertEquals('5 நாட்களில்', $fiveAgo->ago());

        ///

        $oneAgo = Date::parse('1 week');
        $fiveAgo = Date::parse('3 weeks');

        $this->assertEquals('1 வாரத்தில்', $oneAgo->ago());
        $this->assertEquals('3 வாரங்களில்', $fiveAgo->ago());

        ///

        $oneAgo = Date::parse('1 month');
        $fiveAgo = Date::parse('3 months');

        $this->assertEquals('1 மாதத்தில்', $oneAgo->ago());
        $this->assertEquals('3 மாதங்களில்', $fiveAgo->ago());

        ///

        $oneAgo = Date::parse('1 year');
        $fiveAgo = Date::parse('3 years');

        $this->assertEquals('1 ஆண்டில்', $oneAgo->ago());
        $this->assertEquals('3 ஆண்டுகளில்', $fiveAgo->ago());
    }
}
