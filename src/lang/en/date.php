<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | Date Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used by the date library. Each line can
    | have a singular and plural translation separated by a '|'.
    |
    */

    'and'         => 'et',
    'suffixes'    => array('past'      => 'ago',
                           'future'    => 'from now',
                          ),
    'translated'  => array('long' => array('Monday', 'Tuesday', 'Wednesday', 'Thursday',
                                           'Friday', 'Saturday', 'Sunday', 'January',
                                           'February', 'March', 'April', 'May',
                                           'June', 'July', 'August', 'September',
                                           'October', 'November', 'December'),
                           'short' => array('Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun',
                                            'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul',
                                            'Aug', 'Sep', 'Oct', 'Nov', 'Dec'),
                          ),
    'formats'     => array('datetime' => 'Y-m-d H:i:s',
                           'date' => 'Y-m-d',
                           'time' => 'H:i:s',
                           'long' => 'F jS, Y \a\\t H:i',
                           'short' => 'M j, Y',
                           'relative' => '%difference% %suffix%',
                          ),
    'units'       => array('year'      => 'year|years',
                           'month'     => 'month|months',
                           'week'      => 'week|weeks',
                           'day'       => 'day|days',
                           'hour'      => 'hour|hours',
                           'minute'    => 'minute|minutes',
                           'second'    => 'second|seconds',
                          ),

);
