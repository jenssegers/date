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
        $locale = $this->app['translator']->getLocale();

        // Option to have custom resource file for Laravel ^5.1
        $laravel_version = explode('.', $this->app['app']->version());
        if ($laravel_version[0] == 5 && $laravel_version[1] >= 1) {
            $resource = $this->app['path.lang'] . '\vendor\\' . __NAMESPACE__ . '\\' . $locale . '.php';
            file_exists($resource) or $resource = null;
            Date::setLocale($locale, $resource);
            return;
        }

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
        return array('Date');
    }

}
