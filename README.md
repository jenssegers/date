Laravel Date
============

A date library to help you work with dates.

This library was inspired by jasonlewis/expressive-date and CodeIgniter.

Installation
------------

Add the package to your `composer.json` or install manually.

    {
        "require": {
            "jenssegers/date": "*"
        }
    }


Run `composer update` to download and install the package.

Add the service provider in `app/config/app.php`:

    'Jenssegers\Date\DateServiceProvider',

And also add an alias:

	'Date'            => 'Jenssegers\Date\Date',

Usage
-----

### Creating dates

You can create Date objects just like the DateTime object (http://www.php.net/manual/en/datetime.construct.php):

	$date = new Date();
	$date = new Date('2000-01-31');
	$date = new Date('2000-01-31 12:00:00');

	// With time zone
	$date = new Date('2000-01-31', new DateTimeZone('Europe/Brussels'));

	// Relative
	$date = new Date('now');
	$date = new Date('today');
	$date = new Date('+1 hour');
	$date = new Date('next monday');

You can skip the creation of a DateTimeZone object:

	$date = new DateTime('2000-01-31', 'Europe/Brussels');

This is also available from the make or forge static method:

	$date = Date::make('now');
	$date = Date::forge('now');

	$date = Date::now();

Creating a Date from a timestamp:

	$date = new Date(1367186296);

Or from an existing date or time:

	$date = new Date::makeFromDate(2000, 1, 31);
	$date = new Date::makeFromTime(12, 0, 0);
	$date = new Date::makeFromDateTime(2000, 1, 31, 12, 0, 0);

### Formatting Dates

You can format a Date object like the DateTime object (http://www.php.net/manual/en/function.date.php):

	echo Date::now()->format('Y-m-d'); // 2000-01-31

The Date object can be cast to a string:

	echo Date::now(); // 2000-01-31 12:00:00

Get a human readable output:

	echo $date->ago(); // 5 days ago

Or calculate a timespan:

	$date = new Date('+1000 days');
	echo Date::now()->timespan($date);
	// 2 years, 8 months, 3 weeks, 5 days, 0 hour, 0 minute, 0 second