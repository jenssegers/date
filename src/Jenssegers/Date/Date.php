<?php namespace Jenssegers\Date;

use \DateTime;

class Date extends DateTime {

    /**
     * Predefined formats
     *
     * @var array
     */
    protected $formats = array(
        'datetime' => 'Y-m-d H:i:s',
        'date' => 'Y-m-d',
        'time' => 'H:i:s',
    );

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

		$date->setDate($year ?: $date->getYear(), $month ?: $date->getMonth(), $day ?: $date->getDay());

		// If no hour was given then we'll default the minute and second to the current
		// minute and second. If a date was given and minute or second are null then
		// we'll set them to 0, mimicking PHPs behaviour.
		if (is_null($hour))
		{
			$minute = $minute ?: $date->getMinute();
			$second = $second ?: $date->getSecond();
		}
		else
		{
			$minute = $minute ?: 0;
			$second = $second ?: 0;
		}

		$date->setTime($hour ?: $date->getHour(), $minute, $second);

		return $date;

	}

    /**
     * Create and return the current Date instance.
     *
     * @param  string|DateTimeZone  $timezone
     * @return Date
     */
    public static function now($timezone = null)
    {
        return new static(null, $timezone);
    }

    /**
     * Get a relative date string.
     *
     * @param  Date    $since
     * @return string
     */
    public function ago($since = null)
    {
        if (is_null($since)) 
        {
            $since = new static("now", $this->getTimezone());
        }

        $units = array('second', 'minute', 'hour', 'day', 'week', 'month', 'year');
        $values = array(60, 60, 24, 7, 4.35, 12);

        // Date difference
        $difference = abs($since->getTimestamp() - $this->getTimestamp());

        for ($i = 0; $i < count($values) and $difference >= $values[$i]; $i++)
        {
            $difference = $difference / $values[$i];
        }

        // Round the difference.
        $difference = round($difference);

        if ($since->getTimestamp() < $this->getTimestamp())
        {
            $suffix = 'from now';
        }
        else
        {
            $suffix = 'ago';
        }

        // Apply plural
        $unit = $units[$i];

        if ($difference != 1)
        {
            $unit .= 's';
        }

        return $difference.' '.$unit.' '.$suffix;
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

    public function timespan($time = null, $timezone = null)
    {
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
    		$str[] = $interval[$k] . ' ' . $unit . ($interval[$k] > 1 ? 's' : '');
    	}

    	return implode(', ', $str);
    }

    /**
     * Returns date formatted according to given or predefined format.
     *
     * @param  string  $format
     * @return string
     */
    public function format($format)
    {
        if (array_key_exists($format, $this->formats))
        {
            return parent::format($this->formats[$format]);
        }

        return parent::format($format);
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
        if (strpos($method, "forge") == 0)
        {
            $method = str_replace("forge", "make", $method);
            return call_user_func_array(array("self", $method), $args);
        }
    }

}