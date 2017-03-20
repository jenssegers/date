<?php
require 'vendor/autoload.php';

use Jenssegers\Date\Date;

// Set the language
setlocale(LC_ALL, $locale = $argv[1] ?: 'en');

$months = array(
    'january',
    'february',
    'march',
    'april',
    'may',
    'june',
    'july',
    'august',
    'september',
    'october',
    'november',
    'december',
);

$days = array(
    'monday',
    'tuesday',
    'wednesday',
    'thursday',
    'friday',
    'saturday',
    'sunday',
);

$strfDate = array(
    '%A' => 'l', // long dow
    '%B' => 'F', // long moy
    '%a' => 'D', // short dow
    '%b' => 'M', // short moy
    '%Z' => 'T', // tz name
    '%p' => 'A', // AM/PM
    '%P' => 'a', // am/pm
    '%s' => 'U', // timestamp
    '%z' => 'O', // tz offset
    '%G' => 'o', // ISO yr
    '%Y' => 'Y', // cal yr
    '%y' => 'y', // cal yr (pre-y2k)
    '%V' => 'W', // woy 01-53
    '%m' => 'm', // moy 01-12
    '%d' => 'd', // dom 01-31
    '%H' => 'H', // hod 00-23
    '%I' => 'h', // hod 01-12
    '%M' => 'i', // moh 00-59
    '%S' => 's', // som 00-62
    '%w' => 'w', // dow 0-6
    '%u' => 'N', // dow 1-7
    '%e' => 'j', // dom 1-31
    '%l' => 'g', // hod 1-12
);

$translations = require(__DIR__ . '/src/Lang/en.php') ?: array();

foreach ($months as $month) {
    $date = new Date($month);
    $translation = strftime('%B', $date->getTimestamp());
    $translations[$month] = $translation;

    echo "'" . $month . "'\t=> '" . $translation . "',\n";
}

echo "\n";

foreach ($days as $day) {
    $date = new Date($day);
    $translation = strftime('%A', $date->getTimestamp());
    $translations[$day] = $translation;

    echo "'" . $day . "'\t=> '" . $translation . "',\n";
}

echo "\n";

$testStamp1 = (new Date('02 Jan 2005 23:59:58'))->getTimestamp();
$testStamp2 = (new Date('02 Jan 2005 03:59:58'))->getTimestamp();

$testDateTimeString1 = strftime('%c', $testStamp1);
$testDateTimeString2 = strftime('%c', $testStamp2);
$testDateString1 = strftime('%x', $testStamp1);
$testDateString2 = strftime('%x', $testStamp2);
$testTimeString1 = strftime('%X', $testStamp1);
$testTimeString2 = strftime('%X', $testStamp2);

foreach ($strfDate as $strf => $dfmt) {
    $testString1 = strftime($strf, $testStamp1);
    $testString2 = strftime($strf, $testStamp2);

    ($testDateTimeString1 = mb_ereg_replace($testString1, $dfmt, $testDateTimeString1));
    ($testDateTimeString2 = mb_ereg_replace($testString2, $dfmt, $testDateTimeString2));
    ($testDateString1 = mb_ereg_replace($testString1, $dfmt, $testDateString1));
    ($testDateString2 = mb_ereg_replace($testString2, $dfmt, $testDateString2));
    ($testTimeString1 = mb_ereg_replace($testString1, $dfmt, $testTimeString1));
    ($testTimeString2 = mb_ereg_replace($testString2, $dfmt, $testTimeString2));
}

if ($testDateTimeString1 != $testDateTimeString2) {
    $testDateTimeString1 = (mb_ereg('\d+|h', $testDateTimeString1) !== false) ?
                                $testDateTimeString1 :
                                ((mb_ereg('\d+', $testDateTimeString2) !== false) ?
                                    $testDateTimeString2 :
                                    strftime('%c', $testStamp1));
}

if ($testDateString1 != $testDateString2) {
    $testDateString1 = (mb_ereg('\d+|h', $testDateString1) !== false) ?
                                $testDateString1 :
                                ((mb_ereg('\d+', $testDateString2) !== false) ?
                                    $testDateString2 :
                                    strftime('%x', $testStamp1));
}

if ($testTimeString1 != $testTimeString2) {
    $testTimeString1 = (mb_ereg('\d+|h', $testTimeString1) !== false) ?
                                $testTimeString1 :
                                ((mb_ereg('\d+', $testTimeString2) !== false) ?
                                    $testTimeString2 :
                                    strftime('%X', $testStamp1));
}

$translations['format_datetime'] = $testDateTimeString1;
$translations['format_date'] = $testDateString1;
$translations['format_time'] = $testTimeString1;

echo "'format_datetime'\t=> '" . $testDateTimeString1 . "',\n";
echo "'format_date'\t=> '" . $testDateString1 . "',\n";
echo "'format_time'\t=> '" . $testTimeString1 . "',\n";

$langFile = __DIR__ . '/src/Lang/' . str_replace('_', '-', $locale) . '.php';

if (!file_exists($langFile)) {
    file_put_contents($langFile, "<?php\n\nreturn " . var_export($translations, true) . ';');
}
