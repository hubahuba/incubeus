<?php namespace Ngungut\Nccms;

use Illuminate\Support\Facades\Form;
use Illuminate\Support\ServiceProvider;
use Ngungut\Nccms\Libraries\MyURL;
use Ngungut\Nccms\Libraries\MyRedirect;
use Ngungut\Nccms\Libraries\MyValidator;

class NccmsServiceProvider extends ServiceProvider {

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
		$this->package('ngungut/nccms');

        if(\Config::get('nccms::nccms.installed')) {
            $themesPath = \Config::get('nccms::path.themes');
            $activeTheme = Nccms::getActiveTheme();

            //register partial view file
            $partialsPath = $themesPath . $activeTheme . '/' . 'partials';
            $this->app['view']->addNamespace('partial', $partialsPath);

            //register menus view file
            $menusPath = $themesPath . $activeTheme . '/' . 'menus';
            $this->app['view']->addNamespace('menu', $menusPath);

            //register template view file
            $templatesPath = $themesPath . $activeTheme . '/' . 'templates';
            $this->app['view']->addNamespace('template', $templatesPath);
        }

        \Validator::resolver(function($translator, $data, $rules, $messages, $customAttributes)
        {
            return new MyValidator($translator, $data, $rules, $messages, $customAttributes);
        });

        include __DIR__.'/../../routes.php';
        include __DIR__.'/../../filters.php';
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
        $this->app['nccms'] = $this->app->share(function($app)
        {
            return new Nccms;
        });

        $this->app['format'] = $this->app->share(function($app)
        {
            return new Format;
        });

        $this->app['common'] = $this->app->share(function($app)
        {
            return new Common;
        });

        $this->app['themesmanager'] = $this->app->share(function($app)
        {
            return new ThemesManager;
        });

        $this->app->register('CeesVanEgmond\Minify\MinifyServiceProvider');

        $this->app->booting(function()
        {
            $loader = \Illuminate\Foundation\AliasLoader::getInstance();
            $loader->alias('Nccms', 'Ngungut\Nccms\Facades\Nccms');
            $loader->alias('Format', 'Ngungut\Nccms\Facades\Format');
            $loader->alias('Common', 'Ngungut\Nccms\Facades\Common');
            $loader->alias('ThemesManager', 'Ngungut\Nccms\Facades\ThemesManager');
        });

        $this->app['url'] = $this->app->share(function($app)
        {
            return new MyURL(
                \App::make('router')->getRoutes(),
                \App::make('request')
            );
        });

        $this->app['redirect'] = $this->app->share(function($app)
        {
            $redirector = new MyRedirect($app['url']);
            if (isset($app['session.store']))
            {
                $redirector->setSession($app['session.store']);
            }

            return $redirector;
        });

        /**
         * Bind all Controllers
         */
        \App::bindShared('InstallController', function($app){
            return new Controller\InstallController();
        });
        \App::bindShared('AdminController', function($app){
            return new Controller\AdminController();
        });
        \App::bindShared('CategoryController', function($app){
            return new Controller\CategoryController();
        });
        \App::bindShared('CkeditorController', function($app){
            return new Controller\CkeditorController();
        });
        \App::bindShared('FimageController', function($app){
            return new Controller\FimageController();
        });
        \App::bindShared('MediaController', function($app){
            return new Controller\MediaController();
        });
        \App::bindShared('AssetController', function($app){
            return new Controller\AssetController();
        });
        \App::bindShared('MenuController', function($app){
            return new Controller\MenuController();
        });
        \App::bindShared('PartialController', function($app){
            return new Controller\PartialController();
        });
        \App::bindShared('PostController', function($app){
            return new Controller\PostController();
        });
        \App::bindShared('PageController', function($app){
            return new Controller\PageController();
        });
        \App::bindShared('SettingController', function($app){
            return new Controller\SettingController();
        });
        \App::bindShared('TemplateController', function($app){
            return new Controller\TemplateController();
        });
        \App::bindShared('ThemeController', function($app){
            return new Controller\ThemeController();
        });
        \App::bindShared('UsersController', function($app){
            return new Controller\UsersController();
        });

        \App::singleton('pluginNavigation', function($app)
        {
            return Format::renderPluginNavigation();
        });

        //register command Install NCCMS
        $this->app['nccms::commands.install'] = $this->app->share(function($app)
        {
            return new InstallNCCms();
        });

        $this->commands(
            'nccms::commands.install'
        );

        //register command Plugin Install NCCMS
        $this->app['nccms::commands.up'] = $this->app->share(function($app)
        {
            return new InstallPlugin();
        });

        $this->commands(
            'nccms::commands.up'
        );
	}

}
