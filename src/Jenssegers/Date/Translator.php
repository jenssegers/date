<?php namespace Jenssegers\Date;

class Translator {

    /**
     * The current locale.
     *
     * @var  string
     */
    protected $locale = 'en';

    /**
     * The array of loaded translation groups.
     *
     * @var array
     */
    protected $loaded = array();

    /**
     * Get the translation for the given key.
     *
     * @param  string  $key
     * @return string
     */
    public function get($key, array $replace = array())
    {
        if (strpos($key, '::'))
        {
            list($namespace, $key) = explode('::', $key);
        }

        if (strpos($key, '.'))
        {
            list($group, $key) = explode('.', $key);
        }

        $locale = $this->locale;

        // Load language file
        $this->load($group, $locale);

        // Use $key if not found
        if (!isset($this->loaded[$group][$locale][$key])) 
        {
            $string = $key;
        }
        // Get translation
        else
        {
            $string = $this->loaded[$group][$locale][$key];
        }

        // Replace parameters
        foreach ($replace as $key => $value)
        {
            $string = str_replace(":{$key}", $value, $string);
        }

        return $string;
    }

    /**
     * Get a translation according to an integer value.
     *
     * @param  string  $key
     * @param  int     $number
     * @return string
     */
    public function choice($key, $number, array $replace = array())
    {
        $line = $this->get($key, $replace);

        // Only singular
        if (strpos($line, '|') === FALSE) return $line;

        list($singular, $plural) = explode('|', $line);

        // Select string based on number
        return ($number == 1) ? $singular : $plural;
    }

    /**
     * Load the specified language group.
     *
     * @param  string  $group
     * @param  string  $locale
     * @return string
     */
    public function load($group, $locale)
    {
        // Only load once
        if (!isset($this->loaded[$group][$locale]))
        {
            // Full path
            $path = dirname(__FILE__) . "/../../lang/{$locale}/{$group}.php";

            if (file_exists($path))
            {
                // Load language file
                $this->loaded[$group][$locale] = require_once($path);
            }
        }
    }

    /**
     * Set the default locale.
     *
     * @param  string  $locale
     * @return void
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
    }
}