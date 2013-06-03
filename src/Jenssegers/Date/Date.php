<?php namespace Jenssegers\Date;

use \DateTime;
use \DateInterval;
use \DateTimeZone;

class Date extends DateTime {

    /**
     * Strings to translate.
     *
     * @var array
     */
    protected static $to_translate  = array('long' => array('Monday', 'Tuesday', 'Wednesday', 'Thursday',
                                                            'Friday', 'Saturday', 'Sunday', 'January',
                                                            'February', 'March', 'April', 'May',
                                                            'June', 'July', 'August', 'September',
                                                            'October', 'November', 'December'),
                                            'short' => array('Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun',
                                                             'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul',
                                                             'Aug', 'Sep', 'Oct', 'Nov', 'Dec'),
                                            );

    /**
     * The Translator implementation.
     *
     * @var Translator
     */
    protected static $translator;

    /**
     * Returns new DateTime object.
     *
     * @param  string  $time
     * @param  string|DateTimeZone  $timezone
     * @return Date
     */
    public function __construct($time = null, $timezone = null)
    {
        // Create timezone if string was given
        if (is_string($timezone))
        {
            $timezone = new DateTimeZone($timezone);
        }

        // Create timezone if none was given
        if (is_null($timezone))
        {
            $timezone = new DateTimeZone(\Config::get('app.timezone'));
        }

        // Create Date from timestamp
        if (is_int($time))
        {
            $time = "@$time";
        }

        parent::__construct($time, $timezone);
    }

    /**
     * Create and return new Date instance.
     *
     * @param  string  $time
     * @param  string|DateTimeZone  $timezone
     * @return Date
     */
    public static function make($time = null, $timezone = null)
    {
        return new static($time, $timezone);
    }

    /**
     * Create and return a new Date instance with defined year, month, and day.
     *
     * @param  int  $year
     * @param  int  $month
     * @param  int  $day
     * @param  string|DateTimeZone  $timezone
     * @return Date
     */
    public static function makeFromDate($year = null, $month = null, $day = null, $timezone = null)
    {
        return static::makeFromDateTime($year, $month, $day, null, null, null, $timezone);
    }

    /**
     * Create and return a new Date instance with defined hour, minute, and second.
     *
     * @param  int  $hour
     * @param  int  $minute
     * @param  int  $second
     * @param  string|DateTimeZone  $timezone
     * @return Date
     */
    public static function makeFromTime($hour = null, $minute = null, $second = null, $timezone = null)
    {
        return static::makeFromDateTime(null, null, null, $hour, $minute, $second, $timezone);
    }

    /**
     * Create and return a new Date instance with defined year, month, day, hour, minute, and second.
     *
     * @param  int  $year
     * @param  int  $month
     * @param  int  $day
     * @param  int  $hour
     * @param  int  $minute
     * @param  int  $second
     * @param  string|DateTimeZone  $timezone
     * @return Date
     */
    public static function makeFromDateTime($year = null, $month = null, $day = null, $hour = null, $minute = null, $second = null, $timezone = null)
    {
        $date = new static(null, $timezone);

        $date->setDate($year ?: $date->year, $month ?: $date->month, $day ?: $date->day);

        // If no hour was given then we'll default the minute and second to the current
        // minute and second. If a date was given and minute or second are null then
        // we'll set them to 0, mimicking PHPs behaviour.
        if (is_null($hour))
        {
            $minute = $minute ?: $date->minute;
            $second = $second ?: $date->second;
        }
        else
        {
            $minute = $minute ?: 0;
            $second = $second ?: 0;
        }

        $date->setTime($hour ?: $date->hour, $minute, $second);

        return $date;
    }

    /**
     * Return copy of the Date object
     *
     * @return Date
     */
    public function copy()
    {
        return clone $this;
    }

    /**
     * Create and return the current Date instance.
     *
     * @param  string|DateTimeZone  $timezone
     * @return Date
     */
    public static function now($timezone = null)
    {
        // Create timezone if string was given
        if (is_string($timezone))
        {
            $timezone = new DateTimeZone($timezone);
        }

        // Create timezone if none was given
        if (is_null($timezone))
        {
            $timezone = new DateTimeZone(\Config::get('app.timezone'));
        }

        return new static(null, $timezone);
    }

    /**
     * Adds an amount of days, months, years, hours, minutes and seconds to a Date object.
     *
     * @param string|DateInterval $interval
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
     * @param string|DateInterval $interval
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
     * Get a difference in years.
     *
     * @param  Date    $since
     * @return int
     */
    public function age($since = null)
    {
        if (is_null($since))
        {
            $since = new static('now');
        }

        return (int) $this->diff($since)->format('%r%y');
    }

    /**
     * Gets the Unix timestamp.
     *
     * @return int
     */
    public function unix()
    {
        return $this->getTimestamp();
    }

    /**
     * Gets the a timespan.
     *
     * @param Date $time
     * @param string|DateTimeZone $timezone
     * @return int
     */
    public function timespan($time = null, $timezone = null)
    {
        // Get translator
        $lang = $this->getTranslator();

        // Create Date instance if needed
        if (!$time instanceof Date)
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
        foreach ($units as $k=>$unit)
        {
            $str[] = $interval[$k] . ' ' . $lang->choice("date::date.$unit", $interval[$k]);
        }

        return implode(', ', $str);
    }

    /**
     * Get a relative date string.
     *
     * @param Date $time
     * @param string|DateTimeZone $timezone
     * @return int
     */
    public function diffForHumans($time = null, $timezone = null)
    {
        // Get translator
        $lang = $this->getTranslator();

        // Create Date instance if needed
        if (!$time instanceof Date)
        {
            // Create timezone if string was given
            if (is_string($timezone))
            {
                $timezone = new DateTimeZone($timezone);
            }

            // Create timezone if none was given
            if (is_null($timezone))
            {
                $timezone = new DateTimeZone(\Config::get('app.timezone'));
            }

            $time = new static($time, $timezone);
        }

        $units = array('y' => 'year', 'm' => 'month', 'w' => 'week', 'd' => 'day', 'h' => 'hour', 'i' => 'minute');

        // Get DateInterval and cast to array
        $interval = (array) $this->diff($time);

        // Past or future?
        if ($interval['invert'] == 1)
        {
            $suffix = $lang->get('date::date.suffixes.past');
        }
        else
        {
            $suffix = $lang->get('date::date.suffixes.future');
        }

        // Get weeks
        $interval['w'] = (int) ($interval['d'] / 7);
        $interval['d'] = $interval['d'] % 7;

        // Get ready to build
        $str = array();

        // Loop all units and build string
        foreach ($units as $k=>$unit)
        {
            if ($interval[$k] != 0)
            {
                $str[] = $interval[$k] . ' ' . $lang->choice("date::date.units.$unit", $interval[$k]);
            }
        }

        $string = implode(', ', $str);

        $search = strrchr($string, ',');
        $replace = str_replace(',', ' '.$lang->get('date::date.and'), $search);
        $difference = str_replace($search, $replace, $string);

        // Translate month and days.
        $difference = $this->_translate($difference);

        $string = str_replace('%difference%', $difference, $lang->get('date::date.formats.relative'));
        $string = str_replace('%suffix%', $suffix, $string);

        return $string;
    }

    /**
     * Returns date formatted according to given or predefined format.
     *
     * @param  string  $format
     * @return string
     */
    public function format($format)
    {
        // Get translator
        $lang = $this->getTranslator();

        $format = $lang->get("date::date.formats.$format");

        // Date without months and days translated
        $date = parent::format($format);

        return $this->_translate($date);
    }

    /**
     * Returns translated strings for month and days.
     *
     * @param  string  $text
     * @return string
     */
    private function _translate($text)
    {
        // If default language is not english, we need to translated from english
        if (\Config::get('app.locale') != 'en')
        {
            // Get translator
            $lang = $this->getTranslator();

            // Translate long string
            $text = str_replace(static::$to_translate['long'], $lang->get("date::date.translated.long"), $text);

            // Translate short string
            $text = str_replace(static::$to_translate['short'], $lang->get("date::date.translated.short"), $text);
        }

        return $text;
    }

    /**
     * Get a date attribute.
     *
     * @param  string  $attribute
     * @return mixed
     */
    public function get($attribute)
    {
        // Get translator
        $lang = $this->getTranslator();

        $attribute = strtolower($attribute);

        // Without leading zero
        switch ($attribute)
        {
            case 'day':
                return (int) $this->format('j');
                break;
            case 'month':
                return (int) $this->format('n');
                break;
            case 'year':
                return (int) $this->format('Y');
                break;
            case 'hour':
            case 'hours':
                return (int) $this->format('G');
                break;
            case 'minute':
            case 'minutes':
                return (int) $this->format('i');
                break;
            case 'second':
            case 'seconds':
                return (int) $this->format('s');
                break;
            case 'dayofweek':
                return (int) $this->format('w');
                break;
            case 'dayofyear':
                return (int) $this->format('z');
                break;
            case 'weekofyear':
                return (int) $this->format('W');
                break;
            case 'daysinmonth':
                return (int) $this->format('t');
                break;
            case 'age':
                return $this->age();
                break;
            case 'timestamp':
                return (int) $this->getTimestamp();
                break;
        }

        // Date formats given by language file
        $formats = $lang->get('date::date.formats');

        if (array_key_exists($attribute, $formats))
        {
            return $this->format($attribute);
        }
        throw new \InvalidArgumentException("The date attribute '$attribute' could not be found.");
    }

    /**
     * Set a date attribute.
     *
     * @param  string  $attribute
     * @return mixed
     */
    protected function set($attribute, $value)
    {
        $attribute = strtolower($attribute);

        switch ($attribute)
        {
            case 'day':
                return $this->setDate($this->getYear(), $this->getMonth(), $value);
                break;
            case 'month':
                return $this->setDate($this->getYear(), $value, $this->getDay());
                break;
            case 'year':
                return $this->setDate($value, $this->getMonth(), $this->getDay());
                break;
            case 'hour':
            case 'hours':
                return $this->setTime($value, $this->getMinute(), $this->getSecond());
                break;
            case 'minute':
            case 'minutes':
                return $this->setTime($this->getHour(), $value, $this->getSecond());
                break;
            case 'second':
            case 'seconds':
                return $this->setTime($this->getHour(), $this->getMinute(), $value);
                break;
        }

        throw new \InvalidArgumentException("The date attribute '$attribute' could not be set.");
    }

    /**
     * Sets the time zone for the Date object
     *
     * @param  string|DateTimeZone  $timezone
     * @return Date
     */
    public function setTimezone($timezone)
    {
        // Create timezone if string was given
        if (is_string($timezone))
        {
            $timezone = new DateTimeZone($timezone);
        }

        parent::setTimezone($timezone);

        return $this;
    }

    /**
     * Return the datetime format when casting to string.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->format('datetime');
    }

    /**
     * Alias magic
     */
    public static function __callStatic($method, $args)
    {
        if (strpos($method, 'forge') == 0)
        {
            $method = str_replace('forge', 'make', $method);
            return call_user_func_array(array('self', $method), $args);
        }
    }

    /**
     * Alias magic
     */
    public function __call($method, $args)
    {
        $type = substr($method, 0, 3);
        $what = substr($method, 3);

        if ($type == 'get')
        {
            return $this->get($what);
        }

        if ($type == 'set')
        {
            return $this->set($what, $args[0]);
        }
    }

    /**
     * Alias magic
     */
    public function __get($name)
    {
        return $this->get($name);
    }

    /**
     * Alias magic
     */
    public function __set($name, $value)
    {
        return $this->set($name, $value);
    }

    /**
     * Isset
     */
    public function __isset($name)
    {
        try
        {
            $this->get($name);
        }
        catch (\InvalidArgumentException $e)
        {
            return false;
        }

        return true;
    }

    /**
     * Return the Translator implementation
     *
     * @return Translator
     */
    protected function getTranslator()
    {
        // Use own implementation as fallback
        if (!static::$translator)
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

}
