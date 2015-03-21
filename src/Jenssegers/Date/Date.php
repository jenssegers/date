<?php namespace Jenssegers\Date;

use DateTime, DateInterval, DateTimeZone;
use Carbon\Carbon;

class Date extends Carbon {

    /**
     * The Translator implementation.
     *
     * @var Translator
     */
    protected static $translator;

    /**
     * Returns new DateTime object.
     *
     * @param  string               $time
     * @param  string|DateTimeZone  $timezone
     * @return Date
     */
    public function __construct($time = null, $timezone = null)
    {
        // Create Date from timestamp.
        if (is_int($time))
        {
            $time = "@$time";
        }

        parent::__construct($time, $timezone);
    }

    /**
     * Create and return new Date instance.
     *
     * @param  string               $time
     * @param  string|DateTimeZone  $timezone
     * @return Date
     */
    public static function make($time = null, $timezone = null)
    {
        return static::parse($time, $timezone);
    }
    
    /**
     * Create new Date object from format and localized date
     *
     * @param  string  format
     * @param  string  $date
     * @return Date
     */
    public static function createFromFormat($format, $date, $tz = null)
    {
        // Get translator
        $lang = new Translator;
        
        // Get and set locale
        $locale = static::getTranslator()->getLocale();
        $lang->setLocale($locale);
        
        // Get all the language lines of the current locale and of the english file
        $localeLines = $lang->getAllLines('date::date', $locale);
        $englishLines = $lang->getAllLines('date::date', 'en');

        // Filter out all lines that do not exist in the other language
        $localeLines = array_intersect_key($localeLines, $englishLines);
        $englishLines = array_intersect_key($englishLines, $localeLines);
        
        // Sort the lines by key
        ksort($localeLines);
        ksort($englishLines);
        
        // Replace the translated words with the English words
        $date = str_replace($localeLines, $englishLines, $date);

        // Let the parent create the date object
        // now that the date is translated back to English
        return parent::createFromFormat($format, $date, $tz);
    }

    /**
     * Create a carbon instance from a string.
     *
     * @param string              $time
     * @param string|DateTimeZone $timezone
     * @return Date
     */
    public static function parse($time = null, $timezone = null)
    {
        $time = static::translateTimeString($time);

        return parent::parse($time, $timezone);
    }

    /**
     * Create a Carbon instance from a specific format
     *
     * @param string              $format
     * @param string              $time
     * @param DateTimeZone|string $timezone
     * @return static
     * @throws InvalidArgumentException
     */
    public static function createFromFormat($format, $time, $timezone = null)
    {
        $time = static::translateTimeString($time);

        return parent::createFromFormat($format, $time, $timezone);
    }

    /**
     * Get the difference in a human readable format.
     *
     * @param  Date    $since
     * @param  bool    $absolute   Removes time difference modifiers ago, after, etc
     * @return string
     */
    public function diffForHumans(Carbon $since = null, $absolute = false)
    {
        // Get translator
        $lang = $this->getTranslator();

        // Are we comparing against another date?
        $relative = ! is_null($since);

        if (is_null($since))
        {
            $since = new static('now', $this->getTimezone());
        }

        // Are we comparing to a date in the future?
        $future = $since->getTimestamp() < $this->getTimestamp();

        $units = array(
            'second' => 60,
            'minute' => 60,
            'hour'   => 24,
            'day'    => 7,
            'week'   => 30 / 7,
            'month'  => 12,
        );

        // Date difference
        $difference = abs($since->getTimestamp() - $this->getTimestamp());

        // Default unit
        $unit = 'year';

        // Select the best unit.
        foreach ($units as $key => $value)
        {
            if ($difference < $value)
            {
                $unit = $key;
                break;
            }

            $difference = $difference / $value;
        }

        $difference = floor($difference);

        // Select the suffix.
        if ($relative)
        {
            $suffix = $future ? 'after' : 'before';
        }
        else
        {
            $suffix = $future ? 'from_now' : 'ago';
        }

        // Some languages have different unit translations when used in combination
        // with a specific suffix. Here we will check if there is an optional
        // translation for that specific suffix and use it if it exists.
        if ($lang->get("${unit}_diff") != "${unit}_diff")
        {
            $ago = $lang->choice("${unit}_diff", $difference);
        }
        else if ($lang->get("${unit}_${suffix}") != "${unit}_${suffix}")
        {
            $ago = $lang->choice("${unit}_${suffix}", $difference);
        }
        else
        {
            $ago = $lang->choice("$unit", $difference);
        }

        if ($absolute)
        {
            return $ago;
        }

        return $lang->choice("$suffix", $difference, array('time' => $ago));
    }

    /**
     * Alias for diffForHumans.
     *
     * @param  Date   $since
     * @param  bool   $absolute   Removes time difference modifiers ago, after, etc
     * @return string
     */
    public function ago($since = null, $absolute = false)
    {
        return $this->diffForHumans($since, $absolute);
    }

    /**
     * Alias for diffForHumans.
     *
     * @param  Date $since
     * @return string
     */
    public function until($since = null)
    {
        return $this->ago($since);
    }

    /**
     * Returns date formatted according to given or predefined format.
     *
     * @param  string  $format
     * @return string
     */
    public function format($format)
    {
        $replace = array();

        // Loop all format characters and check if we can translate them.
        for ($i = 0; $i < strlen($format); $i++)
        {
            $character = $format[$i];

            // Check if we can replace it with a translated version.
            if (in_array($character, array('D', 'l', 'F', 'M')))
            {
                // Check escaped characters.
                if ($i > 0 and $format[$i-1] == '\\') continue;

                switch ($character)
                {
                    case 'D':
                        $key = parent::format('l');
                        break;
                    case 'M':
                        $key = parent::format('F');
                        break;
                    default:
                        $key = parent::format($character);
                }

                // The original result.
                $original = parent::format($character);

                // Translate.
                $lang = $this->getTranslator();
                $translated = $lang->get('' . strtolower($key));

                // Short notations.
                if (in_array($character, array('D', 'M')))
                {
                    $translated = mb_substr($translated, 0, 3);
                }

                // Add to replace list.
                if ($translated and $original != $translated) $replace[$original] = $translated;
            }
        }

        // Replace translations.
        if ($replace)
        {
            return str_replace(array_keys($replace), array_values($replace), parent::format($format));
        }

        return parent::format($format);
    }

    /**
     * Gets the timespan between this date and another date.
     *
     * @param Date                $time
     * @param string|DateTimeZone $timezone
     * @return int
     */
    public function timespan($time = null, $timezone = null)
    {
        // Get translator
        $lang = $this->getTranslator();

        // Create Date instance if needed
        if ( ! $time instanceof Date)
        {
            $time = new static($time, $timezone);
        }

        $units = array('y' => 'year', 'm' => 'month', 'w' => 'week', 'd' => 'day', 'h' => 'hour', 'i' => 'minute', 's' => 'second');

        // Get DateInterval and cast to array
        $interval = (array) $this->diff($time);

        // Get weeks
        $interval['w'] = (int) ($interval['d'] / 7);
        $interval['d'] = $interval['d'] % 7;

        // Get ready to build
        $str = array();

        // Loop all units and build string
        foreach ($units as $k => $unit)
        {
            if ($interval[$k]) $str[] = $lang->choice("$unit", $interval[$k]);
        }

        return implode(', ', $str);
    }

    /**
     * Adds an amount of days, months, years, hours, minutes and seconds to a Date object.
     *
     * @param  string|DateInterval $interval
     * @return Date
     */
    public function add($interval)
    {
        if (is_string($interval))
        {
            // Check for ISO 8601
            if (strtoupper(substr($interval, 0, 1)) == 'P')
            {
                $interval = new DateInterval($interval);
            }
            else
            {
                $interval = DateInterval::createFromDateString($interval);
            }
        }

        return parent::add($interval);
    }

    /**
     * Subtracts an amount of days, months, years, hours, minutes and seconds from a DateTime object.
     *
     * @param  string|DateInterval $interval
     * @return Date
     */
    public function sub($interval)
    {
        if (is_string($interval))
        {
            // Check for ISO 8601
            if (strtoupper(substr($interval, 0, 1)) == 'P')
            {
                $interval = new DateInterval($interval);
            }
            else
            {
                $interval = DateInterval::createFromDateString($interval);
            }
        }

        return parent::sub($interval);
    }

    /**
     * Set the current locale.
     *
     * @param  string  $locale
     * @return void
     */
    public static function setLocale($locale)
    {
        static::getTranslator()->setLocale($locale);
    }

    /**
     * Return the Translator implementation
     *
     * @return Translator
     */
    public static function getTranslator()
    {
        if ( ! static::$translator)
        {
            static::$translator = new Translator;
        }

        return static::$translator;
    }

    /**
     * Set the Translator implementation
     *
     * @param Translator  $translator
     */
    public static function setTranslator($translator)
    {
        static::$translator = $translator;
    }

    /**
     * Translate a locale based time string to its english equivalent.
     *
     * @param  string $time
     * @return string
     */
    public static function translateTimeString($time)
    {
        // All the language file items we can translate.
        $keys = ['january', 'february', 'march', 'april', 'may', 'june', 'july', 'august', 'september', 'october', 'november', 'december', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];

        // Get all the language lines of the current locale.
        $translator = static::getTranslator();
        $lines = array_intersect_key($translator->getAllLines(), array_flip((array) $keys));

        // Replace the translated words with the English words
        return str_ireplace($lines, array_keys($lines), $time);
    }

}
