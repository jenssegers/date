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
        if (version_compare($this->app->version(), '5.5') >= 0) {
            $eventName = \Illuminate\Foundation\Events\LocaleUpdated::class;
        } else {
            $eventName = 'locale.changed';
        }

        $this->app['events']->listen($eventName, function () {
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
