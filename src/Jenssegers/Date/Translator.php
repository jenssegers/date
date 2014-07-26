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
        if ( ! isset($line)) return "${namespace}::${group}.${item}";

        return $this->makeReplacements($line, $replace);
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
        // Get all plural lines.
        $lines = $this->get($key, $replace, $locale = $locale ?: $this->getLocale());

        $replace['count'] = $number;

        // Let the Symfony MessageSelector do its work.
        return $this->makeReplacements($this->getSelector()->choose($lines, $number, $locale), $replace);
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
