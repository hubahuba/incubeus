<?php namespace Ngungut\Nccms;

use Illuminate\Support\ServiceProvider;
/**
 * Abstract Class For Plugin.
 * User: ngungut_aja
 */

abstract class PluginCore extends ServiceProvider {
    /**
     * @var boolean Determine if this plugin should be loaded (false) or not (true).
     */
    public $disabled = false;

    /**
     * Returns information about this plugin, including plugin name and developer name.
     */
    abstract public function pluginDetails();

    /**
     * Registers any front-end components implemented in this plugin.
     */
    public function registerComponents()
    {
        return [];
    }

    /**
     * Registers back-end navigation items for this plugin.
     */
    public function registerNavigation()
    {
        return [];
    }

    /**
     * Register method, called when the plugin is first registered.
     */
    public function register()
    {
    }

    /**
     * Boot method, called right before the request route.
     */
    public function boot()
    {
    }

    /**
     * Registers a new console (artisan) command
     * @param $key The command name
     * @param $class The command class
     * @return void
     */
    public function registerConsoleCommand($key, $class)
    {
        $key = 'command.'.$key;
        $this->app[$key] = $this->app->share(function ($app) use ($class) {
            return new $class;
        });

        $this->commands($key);
    }
}