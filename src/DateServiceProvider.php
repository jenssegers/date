<?php

namespace Jenssegers\Date;

use Illuminate\Support\ServiceProvider;

class DateServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        $localeChangedEvents = [
            'locale.changed',
            // Laravel 5.6+
            // @see https://github.com/laravel/framework/commit/3385fdc0f8e4890ab57261755bcbbf79f9ec828d#diff-7b18a52eceff5eb716c1de268e98d55dR1045
            '\\Illuminate\\Foundation\\Events\\LocaleUpdated',
        ];
        $this->app['events']->listen($localeChangedEvents, function () {
            $this->setLocale();
        });

        $this->setLocale();
    }

    /**
     * Set the locale.
     */
    protected function setLocale()
    {
        $locale = $this->app['translator']->getLocale();

        Date::setLocale($locale);
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        // Nothing.
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['Date'];
    }
}
