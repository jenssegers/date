<?php namespace Jenssegers\Date;

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
     *
     * @return void
     */
    public function boot()
    {
        $this->app['events']->listen('locale.changed', function () {
            $this->setLocale();
        });

        $this->setLocale();
    }

    /**
     * Set the locale.
     *
     */
    protected function setLocale()
    {
        $locale = $this->app['translator']->getLocale();

        Date::setLocale($locale);
    }

    /**
     * Register the service provider.
     *
     * @return void
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
