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
     * @param  array   $replace
     * @param  string  $locale
     * @return string
     */
    public function get($key, array $replace = array(), $locale = null)
    {
        list($namespace, $group, $item) = $this->parseKey($key);

        // Get the current locale.
        if ( ! $locale) $locale = $this->getLocale();

        // Load the language file.
        $this->load($namespace, $group, $locale);

        // Get the translation.
        if (isset($this->loaded[$group][$locale][$item]))
        {
            $line = $this->loaded[$group][$locale][$item];
        }

        // If the line doesn't exist, we will return back the item which was requested.
        if ( ! isset($line)) return $item;

        // Replace parameters.
        foreach ($replace as $key => $value)
        {
            $line = str_replace(":{$key}", $value, $line);
        }

        return $line;
    }

    /**
     * Get a translation according to an integer value.
     *
     * @param  string  $key
     * @param  int     $number
     * @param  array   $replace
     * @param  string  $locale
     * @return string
     */
    public function choice($key, $number, array $replace = array(), $locale = null)
    {
        $line = $this->get($key, $replace, $locale);

        // Check if there is a plurar form available, otherwise just return
        // the single item.
        if (strpos($line, '|') === FALSE) return $line;

        list($singular, $plural) = explode('|', $line);

        // Select string based on number
        return ($number == 1) ? $singular : $plural;
    }

    /**
     * Load the specified language group.
     *
     * @param  string  $namespace
     * @param  string  $group
     * @param  string  $locale
     * @return void
     */
    public function load($namespace, $group, $locale)
    {
        if ($this->isLoaded($namespace, $group, $locale)) return;

        $path = __DIR__."/../../lang/{$locale}/{$group}.php";

        if (file_exists($path))
        {
            $this->loaded[$group][$locale] = require $path;
        }
    }

    /**
     * Determine if the given group has been loaded.
     *
     * @param  string  $namespace
     * @param  string  $group
     * @param  string  $locale
     * @return bool
     */
    protected function isLoaded($namespace, $group, $locale)
    {
        return isset($this->loaded[$namespace][$group][$locale]);
    }

    /**
     * Parse a key into namespace, group, and item.
     *
     * @param  string  $key
     * @return array
     */
    public function parseKey($key)
    {
        if (strpos($key, '::'))
        {
            list($namespace, $key) = explode('::', $key);
        }

        if (strpos($key, '.'))
        {
            list($group, $key) = explode('.', $key);
        }

        return array($namespace, $group, $key);
    }

    /**
     * Get the default locale being used.
     *
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
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
