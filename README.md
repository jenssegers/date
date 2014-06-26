Laravel Date
============

[![Build Status](http://img.shields.io/travis/jenssegers/laravel-date.svg)](https://travis-ci.org/jenssegers/laravel-date) [![Coverage Status](http://img.shields.io/coveralls/jenssegers/laravel-date.svg)](https://coveralls.io/r/jenssegers/laravel-date?branch=master)

This date library is extends [Carbon](https://github.com/briannesbitt/Carbon) with multi-language support. Methods such as `format`, `diffForHumans` and the new `timespan`, will now be translated based on your locale.

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

Languages
---------

This package contains language files for the following languages:

 - German
 - English
 - Spanish
 - Basque
 - Finnish (incomplete)
 - French
 - Italian
 - Dutch
 - Polish
 - Portuguese
 - Swedish (incomplete)
 - Turkish (incomplete)

You can easily add new languages by adding a new language file to the *lang* directory. These language entries support pluralization. By using a "pipe" character, you may separate the singular and plural forms of a string:

    'hour'      => '1 hour|%number% hours',
    'minute'    => '1 minute|%number% minutes',
    'second'    => '1 second|%number% seconds',

If you are using Laravel, the locale set in `app/config/app.php` will be used to select the correct language file. If not, you can manually set the current locale using:

    Date::setLocale('nl');

There is also a `generator.php` script that can be used to quickly output day and month translations for a specific locale. If you want to add a new language, this can speed up the process:

    `php generator.php nl_NL`

Usage
-----

The Date class extends Carbon methods such as `format` and `diffForHumans` so that they are translated based on your locale:

    Lang::setLocale('nl');

    echo Date::now()->format('l j F Y H:i:s'); // zondag 28 april 2013 21:58:16

    echo Date::parse('-1 day')->diffForHumans(); // 1 dag geleden

The Date class also added some aliases and additional methods such as: `ago` which is an alias for `diffForHumans`, and the `timespan` method:

    echo $date->timespan(); // 0 years, 3 months, 1 week, 1 day, 3 hours, 20 minutes, 0 seconds

Carbon
------

Carbon is the library the Date class is based on. All of the original Carbon operations are still available, check out https://github.com/briannesbitt/Carbon for more information.

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

### Manipulating Dates

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
