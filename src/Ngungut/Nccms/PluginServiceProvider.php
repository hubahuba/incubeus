<?php namespace Ngungut\Nccms;

use Illuminate\Support\ServiceProvider;

class PluginServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

    protected $pluginmanager;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //register config
        $this->app['config']->package('ngungut/nccms', __DIR__.'/../../config');
        //register plugin manager
        $this->app['pluginmanager'] = $this->app->share(function($app)
        {
            return PluginManager::instance();
        });

        $this->pluginmanager = PluginManager::instance();
        $this->pluginmanager->registerAll();
    }

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
        $this->pluginmanager->bootAll();
	}

    /**
     * Get the services provided by the provider.
     * @return array
     */
    public function provides()
    {
        return array();
    }
}
