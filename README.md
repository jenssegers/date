Laravel Date
============

[![Build Status](http://img.shields.io/travis/jenssegers/laravel-date.svg)](https://travis-ci.org/jenssegers/laravel-date)

This date library is based on Carbon and adds language support.

Installation
------------

Add the package to your `composer.json` and run `composer update`.

    {
        "require": {
            "jenssegers/date": "*"
        }
    }

This package is compatible with Laravel 4 (but not limited to). If Laravel is detected, the language library from Laravel will be used instead of an own implementation.

Add the service provider in `app/config/app.php`:

    'Jenssegers\Date\DateServiceProvider',

And add an alias:

    'Date'            => 'Jenssegers\Date\Date',

Usage
-----

All of the original Carbon operations are still available, check out https://github.com/briannesbitt/Carbon for more information.

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

This is also available using these static methods:

    $date = Date::parse('now');
    $date = Date::now();

Creating a Date from a timestamp:

    $date = new Date(1367186296);

Or from an existing date or time:

    $date = new Date::createFromDate(2000, 1, 31);
    $date = new Date::createFromTime(12, 0, 0);
    $date = new Date::create(2000, 1, 31, 12, 0, 0);

### Formatting Dates

You can format a Date object like the DateTime object (http://www.php.net/manual/en/function.date.php):

    echo Date::now()->format('Y-m-d'); // 2000-01-31

The Date object can be cast to a string:

    echo Date::now(); // 2000-01-31 12:00:00

Get a human readable output (alias for diffForHumans):

    echo $date->ago(); // 5 days ago

Calculate a timespan:

    $date = new Date('+1000 days');
    echo Date::now()->timespan($date);
    // 2 years, 8 months, 3 weeks, 5 days, 0 hour, 0 minute, 0 second

    // or even
    echo Date::now()->timespan('+1000 days');

Get years since date:

    $date = new Date('-10 years');
    echo $date->age; // 10

    $date = new Date('+10 years');
    echo $date->age; // -10

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
    $date->minute = 0;
    $date->second = 0;

Localization
------------

There's some magic under the hood of the `format` method. It will check if there are any available translations using the [strftime](http://be2.php.net/manual/en/function.strftime.php) method. This does require you to set the correct locale:

    setlocale(LC_TIME, "nl_NL");
    echo $date->format('l j F Y H:i:s'); // zondag 28 april 2013 21:58:16

The `ago` and `timestamp` method also support different languages. Language strings for these methods are stored in files within the *lang* directory. By using a "pipe" character, you may separate the singular and plural forms of a string:

    'hour'      => '1 hour|%number% hours',
    'minute'    => '1 minute|%number% minutes',
    'second'    => '1 second|%number% seconds',

If you are using Laravel, the locale set in `app/config/app.php` will be used.
