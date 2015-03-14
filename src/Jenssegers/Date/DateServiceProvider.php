<?php namespace Jenssegers\Date;

use Illuminate\Support\ServiceProvider;

class DateServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        // Laravel 5 resource registration
        if (method_exists($this, 'loadTranslationsFrom'))
        {
            $this->loadTranslationsFrom($this->app->basePath() . '/vendor/jenssegers/date/src/lang', 'date');
        }
        // Laravel 4 package registration
        else if (method_exists($this, 'package'))
        {
            $this->package('jenssegers/date');
        }

        // Use the Laravel translator.
        Date::setTranslator($this->app['translator']);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('Date');
    }

}
