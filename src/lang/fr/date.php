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
    'suffixes'    => array('past'      => 'il y a',
                           'future'    => 'dans',
                          ),
    'translated'  => array('long' => array('lundi', 'mardi', 'mercredi', 'jeudi',
                                           'vendredi', 'samedi', 'dimanche', 'janvier',
                                           'février', 'mars', 'avril', 'mai',
                                           'juin', 'juillet', 'août', 'septembre',
                                           'octobre', 'novembre', 'décembre'),
                           'short' => array('lun', 'mar', 'mer', 'jeu', 'ven', 'sam', 'dim',
                                            'jan', 'fév', 'mar', 'avr', 'mai', 'jui', 'jui',
                                            'aoû', 'sep', 'oct', 'nov', 'déc'),
                          ),
    'formats'     => array('datetime' => 'd/m/Y H:i:s',
                           'date' => 'd/m/Y',
                           'time' => 'H:i:s',
                           'long' => 'l j F Y à H:i',
                           'short' => 'j M Y',
                           'relative' => '%suffix% %difference%',
                          ),
    'units'       => array('year'      => 'an|ans',
                           'month'     => 'mois|mois',
                           'week'      => 'semaine|semaines',
                           'day'       => 'jour|jours',
                           'hour'      => 'heure|heures',
                           'minute'    => 'minute|minutes',
                           'second'    => 'seconde|secondes',
                          ),

);
