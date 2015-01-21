<?php namespace Ngungut\Nccms;

use Illuminate\Support\ServiceProvider;
/**
 * Abstract Class For Theme.
 * User: ngungut_aja
 */

abstract class ThemeCore extends ServiceProvider {
    /**
     * @var boolean Determine if this plugin should be loaded (false) or not (true).
     */
    public $disabled = false;

    /**
     * Returns information about this plugin, including plugin name and developer name.
     */
    abstract public function themeDetails();

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
}