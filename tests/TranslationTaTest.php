<?php

namespace Tests\Jenssegers;

use Jenssegers\Date\Date;

class TranslationTaTest extends TestCaseBase
{
    const LOCALE = 'ta';

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

        $this->assertEquals('ஜனவரி', $jan->format('F'));
        $this->assertEquals('பிப்ரவரி', $feb->format('F'));
        $this->assertEquals('மார்ச்', $mar->format('F'));
        $this->assertEquals('ஏப்ரல்', $apr->format('F'));
        $this->assertEquals('மே', $may->format('F'));
        $this->assertEquals('ஜூன்', $jun->format('F'));
        $this->assertEquals('ஜூலை', $jul->format('F'));
        $this->assertEquals('ஆகஸ்ட்', $aug->format('F'));
        $this->assertEquals('செப்டெம்பர்', $sep->format('F'));
        $this->assertEquals('அக்டோபர்', $oct->format('F'));
        $this->assertEquals('நவம்பர்', $nov->format('F'));
        $this->assertEquals('டிசம்பர்', $dec->format('F'));
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
        $this->assertEquals('செவ்வாய்கிழமை', $tue->format('l'));
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

        $this->assertEquals('1 சில விநாடிகள் முன்', $oneAgo->ago());
        $this->assertEquals('5 விநாடிகள் முன்', $fiveAgo->ago());

        ///

        $oneAgo = Date::parse('-1 minute');
        $fiveAgo = Date::parse('-5 minutes');

        $this->assertEquals('1 நிமிடம் முன்', $oneAgo->ago());
        $this->assertEquals('5 நிமிடங்கள் முன்', $fiveAgo->ago());

        ///

        $oneAgo = Date::parse('-1 hour');
        $fiveAgo = Date::parse('-5 hours');

        $this->assertEquals('1 மணி நேரம் முன்', $oneAgo->ago());
        $this->assertEquals('5 மணி நேரம் முன்', $fiveAgo->ago());

        ///

        $oneAgo = Date::parse('-1 day');
        $fiveAgo = Date::parse('-5 days');

        $this->assertEquals('1 நாள் முன்', $oneAgo->ago());
        $this->assertEquals('5 நாட்கள் முன்', $fiveAgo->ago());

        ///

        $oneAgo = Date::parse('-1 week');
        $fiveAgo = Date::parse('-3 weeks');

        $this->assertEquals('1 வாரம் முன்', $oneAgo->ago());
        $this->assertEquals('3 வாரங்கள் முன்', $fiveAgo->ago());

        ///

        $oneAgo = Date::parse('-1 month');
        $fiveAgo = Date::parse('-3 months');

        $this->assertEquals('1 மாதம் முன்', $oneAgo->ago());
        $this->assertEquals('3 மாதங்கள் முன்', $fiveAgo->ago());

        ///

        $oneAgo = Date::parse('-1 year');
        $fiveAgo = Date::parse('-3 years');

        $this->assertEquals('1 வருடம் முன்', $oneAgo->ago());
        $this->assertEquals('3 ஆண்டுகள் முன்', $fiveAgo->ago());
    }

    /** @test */
    public function it_translates_from_now()
    {
        $oneAgo = Date::parse('1 second');
        $fiveAgo = Date::parse('5 seconds');

        $this->assertEquals('1 சில விநாடிகள் இல்', $oneAgo->ago());
        $this->assertEquals('5 விநாடிகள் இல்', $fiveAgo->ago());

        ///

        $oneAgo = Date::parse('1 minute');
        $fiveAgo = Date::parse('5 minutes');

        $this->assertEquals('1 நிமிடம் இல்', $oneAgo->ago());
        $this->assertEquals('5 நிமிடங்கள் இல்', $fiveAgo->ago());

        ///

        $oneAgo = Date::parse('1 hour');
        $fiveAgo = Date::parse('5 hours');

        $this->assertEquals('1 மணி நேரம் இல்', $oneAgo->ago());
        $this->assertEquals('5 மணி நேரம் இல்', $fiveAgo->ago());

        ///

        $oneAgo = Date::parse('1 day');
        $fiveAgo = Date::parse('5 days');

        $this->assertEquals('1 நாள் இல்', $oneAgo->ago());
        $this->assertEquals('5 நாட்கள் இல்', $fiveAgo->ago());

        ///

        $oneAgo = Date::parse('1 week');
        $fiveAgo = Date::parse('3 weeks');

        $this->assertEquals('1 வாரம் இல்', $oneAgo->ago());
        $this->assertEquals('3 வாரங்கள் இல்', $fiveAgo->ago());

        ///

        $oneAgo = Date::parse('1 month');
        $fiveAgo = Date::parse('3 months');

        $this->assertEquals('1 மாதம் இல்', $oneAgo->ago());
        $this->assertEquals('3 மாதங்கள் இல்', $fiveAgo->ago());

        ///

        $oneAgo = Date::parse('1 year');
        $fiveAgo = Date::parse('3 years');

        $this->assertEquals('1 வருடம் இல்', $oneAgo->ago());
        $this->assertEquals('3 ஆண்டுகள் இல்', $fiveAgo->ago());
    }
}
