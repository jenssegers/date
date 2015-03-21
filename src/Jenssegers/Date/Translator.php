<?php namespace Jenssegers\Date;

use Symfony\Component\Translation\MessageSelector;

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
     * A cache of the parsed items.
     *
     * @var array
     */
    protected $parsed = array();

    /**
     * Determine if a translation exists.
     *
     * @param  string  $key
     * @param  string  $locale
     * @return bool
     */
    public function has($key, $locale = null)
    {
        return $this->get($key, array(), $locale) !== $key;
    }

    /**
     * Get the translation for the given key.
     *
     * @param  string  $key
     * @param  array   $replace
     * @param  string  $locale
     * @return string
     */
    public function get($item, array $replace = array(), $locale = null)
    {
        if ( ! $locale) $locale = $this->getLocale();

        $this->load($locale);

        $line = $this->getLine($locale, $item, $replace);

        // If the line doesn't exist, we will return back the key which was requested as
        // that will be quick to spot in the UI if language keys are wrong or missing
        // from the application's language files. Otherwise we can return the line.
        if ( ! isset($line)) return $item;

        return $line;
    }

    /**
     * Retrieve a language line out the loaded array.
     *
     * @param  string  $namespace
     * @param  string  $group
     * @param  string  $locale
     * @param  string  $item
     * @param  array   $replace
     * @return string|null
     */
    protected function getLine($locale, $item, array $replace)
    {
        if (isset($this->loaded[$locale][$item]))
        {
            $line = $this->loaded[$locale][$item];

            if (is_string($line))
            {
                return $this->makeReplacements($line, $replace);
            }
            elseif (is_array($line) && count($line) > 0)
            {
                return $line;
            }
        }
    }

    /**
     * Retrieve all language lines out the loaded array.
     *
     * @param  string  $locale
     * @return array|null
     */
    public function getAllLines($locale = null)
    {
        if ( ! $locale) $locale = $this->getLocale();

        $this->load($locale);

        if (isset($this->loaded[$locale]))
        {
            return $this->loaded[$locale];
        }
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
        $line = $this->get($key, $replace, $locale = $locale ?: $this->locale);

        $replace['count'] = $number;

        return $this->makeReplacements($this->getSelector()->choose($line, $number, $locale), $replace);
    }

    /**
     * Load the specified language group.
     *
     * @param  string  $namespace
     * @param  string  $group
     * @param  string  $locale
     * @return void
     */
    public function load($locale)
    {
        if ($this->isLoaded($locale)) return;

        $path = __DIR__."/../../lang/{$locale}/date.php";

        if (file_exists($path))
        {
            $this->loaded[$locale] = require $path;
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
    protected function isLoaded($locale)
    {
        return isset($this->loaded[$locale]);
    }

    /**
     * Make the place-holder replacements on a line.
     *
     * @param  string  $line
     * @param  array   $replace
     * @return string
     */
    protected function makeReplacements($line, array $replace)
    {
        foreach ($replace as $key => $value)
        {
            $line = str_replace(':'.$key, $value, $line);
        }

        return $line;
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

    /**
     * Get the message selector instance.
     *
     * @return \Symfony\Component\Translation\MessageSelector
     */
    public function getSelector()
    {
        if ( ! isset($this->selector))
        {
            $this->selector = new MessageSelector;
        }

        return $this->selector;
    }

    /**
     * Set the message selector instance.
     *
     * @param  \Symfony\Component\Translation\MessageSelector  $selector
     * @return void
     */
    public function setSelector(MessageSelector $selector)
    {
        $this->selector = $selector;
    }

}
