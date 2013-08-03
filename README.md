Laravel Date [![Build Status](https://travis-ci.org/jenssegers/Laravel-Date.png?branch=master)](https://travis-ci.org/jenssegers/Laravel-Date)
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

Laravel
-------

This package is compatible with Laravel 4 (but not limited to). If Laravel is detected, the language library from Laravel will be used instead of an own implementation.

Add the service provider in `app/config/app.php`:

    'Jenssegers\Date\DateServiceProvider',

And add an alias:

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

You can skip the creation of a DateTimeZone object:

    $date = new Date('2000-01-31', 'Europe/Brussels');

Create Date objects from a relative format (http://www.php.net/manual/en/datetime.formats.relative.php):
    
    $date = new Date('now');
    $date = new Date('today');
    $date = new Date('+1 hour');
    $date = new Date('next monday');

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

There are predefined patterns that can be used:

    echo $date->format('datetime'); // 2000-01-31 12:00:00
    echo $date->format('date');  // 2000-01-31
    echo $date->format('time'); // 12:00:00

    echo $date->format('long'); // January 31st, 2000 at 12:00
    echo $date->format('short'); // Jan 31, 2000

Predefined patterns have a corresponding get method and attribute:

    echo $date->getTime();
    echo $date->time;

    echo $date->getLong();
    echo $date->long;

The Date object can be cast to a string:

    echo Date::now(); // 2000-01-31 12:00:00

Get a human readable output:

    echo $date->ago(); // 5 days ago

Calculate a timespan:

    $date = new Date('+1000 days');
    echo Date::now()->timespan($date);
    // 2 years, 8 months, 3 weeks, 5 days, 0 hour, 0 minute, 0 second

    // or even
    echo Date::now()->timespan('+1000 days');

Get years since date:

    $date = new Date('-10 years');
    echo $date->age(); // 10

    $date = new Date('+10 years');
    echo $date->age(); // -10

Manipulating Dates
------------------

You can manipulate by using the *add* and *sub* methods, with relative intervals (http://www.php.net/manual/en/datetime.formats.relative.php):

    $yesterday = Date::now()->sub('1 day');
    $tomorrow  = Date::now()->add('1 day');

    // ISO 8601
    $date = Date::now()->add('P2Y4DT6H8M');

You can access and modify all date attributes as an object:

    $date->year = 2013:
    $date->month = 1;
    $date->day = 31;

    $date->hour = 12;
    $date->minutes = 0;
    $date->seconds = 0;

All attributes have a corresponding get or set method:

    $date->setYear(2013);
    $date->setHour(12);

    echo $date->getMonth();
    echo $date->getSeconds();

Localization
------------

Language strings are stored in files within the *lang* directory. By using a "pipe" character, you may separate the singular and plural forms of a string:

    'hour'      => '1 hour|%number% hours',
    'minute'    => '1 minute|%number% minutes',
    'second'    => '1 second|%number% seconds',

If you are using Laravel, the locale set in `app/config/app.php` will be used.
