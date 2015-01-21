<?php namespace Ngungut\Nccms\Controller;

use BaseController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Ngungut\Nccms\Model\User as User;
use Ngungut\Nccms\Model\Settings;

/**
 * Class AdminController
 * Contain Dashboard, Login, Logout handler
 */
class InstallController extends BaseController {

    /**
     * set default layout
     * @var string
     */
    protected $layout = 'nccms::layouts.install';

    /**
     * Init Installation Page
     */
    public function initiate()
    {
        return \View::make('nccms::install.init');
    }

    /**
     * Init Installation Folder
     */
    public function initFolder()
    {
        //remove local and testing config
        $local = app_path() . '/config/local';
        \File::deleteDirectory($local);
        $testing = app_path() . '/config/testing';
        \File::deleteDirectory($testing);

        //create plugins folder
        if(!is_dir(base_path() . '/nccms/plugins')){
            if(!is_dir(base_path() . '/nccms')){
                mkdir(base_path() . '/nccms');
            }
            mkdir(base_path() . '/nccms/plugins');
            //copy default plugin folder
            \File::copyDirectory(__DIR__ . '/../plugins', base_path() . '/nccms/plugins');
        }
        if(!is_dir(base_path() . '/nccms/themes')){
            if(!is_dir(base_path() . '/nccms')){
                mkdir(base_path() . '/nccms');
            }
            mkdir(base_path() . '/nccms/themes');
            //copy default themes folder to nccms
            \File::copyDirectory(__DIR__ . '/../themes', base_path() . '/nccms/themes');
        }
        if(!is_dir(public_path() . '/themes')){
            mkdir(public_path() . '/themes');
            //copy default themes folder to public
            mkdir(public_path() . '/themes/waldo');
            \File::copyDirectory(__DIR__ . '/../themes/waldo/assets', public_path() . '/themes/waldo');
            //remove build folder
            \File::deleteDirectory(public_path() . '/themes/waldo/build');
            //create folder builds
            mkdir(public_path() . '/themes/waldo/builds');
        }
        if(!is_dir(public_path() . '/uploads')){
            mkdir(public_path() . '/uploads');
        }

        return \Response::json(['text' => 'Copying Folder Structure']);
    }

    /**
     * Database Configuration page
     *
     */
	public function index()
	{
        $nccmsPath = base_path() . '/nccms';
        if(is_dir($nccmsPath) == false){
            return \Redirect::to('installation/init');
        }
        $mysql = \Config::get('database.connections.mysql');
        $this->layout->title = 'Database Configuration';
        $this->layout->content = \View::make('nccms::install.setDatabase')
            ->with('title', 'Database Configuration')
            ->with('config', $mysql);
	}

    /**
     * Database Configuration Rewrite Action
     *
     */
    public function doDatabase(){
        $rules = array(
            'host' => 'required',
            'port' => 'numeric',
            'username' => 'required',
            'database' => 'required',
        );
        $display = array(
            'host' => 'Database Host',
            'username' => 'Database Username',
            'database' => 'Database Database',
        );

        $validator = \Validator::make(\Input::all(), $rules, array(), $display);
        if($validator->fails()) {
            return \Redirect::back()
                ->withErrors($validator)
                ->withInput(\Input::all());
        }else{
            $driver = 'mysql';
            $host = \Input::get('host');
            $username = \Input::get('username');
            $password = \Input::has('password') ? \Input::get('password'):'';
            $database = \Input::get('database');
            $port = \Input::has('port') ? \Input::get('port'):'3306';
            $prefix = \Input::has('prefix') ? \Input::get('prefix'):'';

            Config::set('database.connections.'.$driver.'.driver', $driver);
            Config::set('database.connections.'.$driver.'.host', $host);
            Config::set('database.connections.'.$driver.'.username', $username);
            Config::set('database.connections.'.$driver.'.password', $password);
            Config::set('database.connections.'.$driver.'.database', $database);
            Config::set('database.connections.'.$driver.'.port', $port);
            Config::set('database.connections.'.$driver.'.prefix', $prefix);

            try{
                $database = \DB::connection()->getDatabaseName();
            }catch(\Exception $e){
                return \Redirect::back()
                    ->withErrors(['connection' => $e->getMessage()])
                    ->withInput(\Input::all());
            }

            $newConfig = '\'default\' => \''.$driver.'\',

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the database connections setup for your application.
    | Of course, examples of configuring each database platform that is
    | supported by Laravel is shown below to make development simple.
    |
    |
    | All database work in Laravel is done through the PHP PDO facilities
    | so make sure you have the driver for your particular database of
    | choice installed on your machine before you begin development.
    |
    */

    \'connections\' => array(

        \''.$driver.'\' => array(
            \'driver\' => \''.$driver.'\',
            \'host\' => \''.$host.'\',
            \'username\' => \''.$username.'\',
            \'password\' => \''.$password.'\',
            \'database\' => \''.$database.'\',
            \'port\' => \''.$port.'\',
            \'charset\'   => \'utf8\',
            \'collation\' => \'utf8_unicode_ci\',
            \'prefix\' => \''.$prefix.'\',
        ),

    ),

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | This table keeps track of all the migrations that have already run for
    | your application. Using this information, we can determine which of
    | the migrations on disk haven`t actually been run in the database.
    |
    */

    \'migrations\' => \'migrations\',

);';
            $dbConfig = app_path() . '/config/database.php';
            $content = file_get_contents($dbConfig);
            $pos = strpos($content, '\'default\'');
            $extractContent = substr($content, 0, $pos);
            file_put_contents($dbConfig, $extractContent.$newConfig);

            //remove local and testing config
            $local = app_path() . '/config/local';
            \File::deleteDirectory($local);
            $testing = app_path() . '/config/testing';
            \File::deleteDirectory($testing);
            Artisan::call('migrate', ['--package' => 'ngungut/nccms', '--force' => true]);

            return Redirect::to('installation/user');
        }
    }

    /**
     * Administrator User Creation Page
     *
     */
    public function users()
    {
        $nccmsPath = base_path() . '/nccms';
        if(is_dir($nccmsPath) == false){
            return \Redirect::to('installation/init');
        }
        $user = User::first();
        $this->layout->title = 'Administrator User Creation';
        $this->layout->content = \View::make('nccms::install.setUser')
            ->with('title', 'Administrator User Creation')
            ->with('user', $user);
    }

    public function doUser(){
        $rules = array(
            'username' => 'required|max:30',
            'password' => 'required|same:repassword|min:7',
            'repassword' => 'required|min:7',
            'firstname' => 'required|max:60',
            'lastname' => 'required|max:60',
            'nickname' => 'required|max:60',
        );
        $display = array(
            'username' => 'Username',
            'password' => 'Password',
            'repassword' => 'Confirmation Password',
            'firstname' => 'Firstname',
            'lastname' => 'Lastname',
            'nickname' => 'Nickname',
        );

        $validator = \Validator::make(\Input::all(), $rules, array(), $display);
        if($validator->fails()) {
            return \Redirect::back()
                ->withErrors($validator)
                ->withInput(\Input::all());
        }else{
            if(\Input::has('id')){
                $user = User::find(\Input::get('id'));
                $user->username = Input::get('username');
                $user->password = \Hash::make(Input::get('password'));
                $user->firstname = Input::get('firstname');
                $user->lastname = Input::get('lastname');
                $user->nickname = Input::get('nickname');
                $user->save();
            }else {
                $user = User::create([
                    'username' => Input::get('username'),
                    'password' => \Hash::make(Input::get('password')),
                    'firstname' => Input::get('firstname'),
                    'lastname' => Input::get('lastname'),
                    'nickname' => Input::get('nickname'),
                    'level' => 1,
                ]);
            }
            if($user->id){
                Session::put('logedin', $user->id);
                Session::put('loginLevel', $user->level);
                Session::put('nickname', $user->nickname);
                Artisan::call('db:seed', ['--class' => 'NccmsSeeder', '--force' => true]);
            }
            return Redirect::to('installation/setting');
        }
    }

    /**
     * Website Configuration page
     *
     */
    public function setting()
    {
        $nccmsPath = base_path() . '/nccms';
        if(is_dir($nccmsPath) == false){
            return \Redirect::to('installation/init');
        }
        $this->layout->title = 'Website Configuration';
        $this->layout->content = \View::make('nccms::install.setGeneral')
            ->with('site', Settings::getSite())
            ->with('title', 'Website Configuration');
    }

    public function doSetting(){
        $rules = array(
            'siteTitle' => 'required',
            'siteTagline' => 'required',
            'dateFormat' => 'required',
            'dateCustom' => 'required_if:dateFormat,custom',
            'timeFormat' => 'required',
            'timeCustom' => 'required_if:timeFormat,custom',
        );
        $display = array(
            'siteTitle' => 'Site Title',
            'siteTagline' => 'Site Tagline',
            'dateFormat' => 'Site Date Format',
            'dateCustom' => 'Site Custom Date Format',
            'timeFormat' => 'Site Time Format',
            'timeCustom' => 'Site Custom Time Format',
        );

        $validator = \Validator::make(\Input::all(), $rules, array(), $display);
        if($validator->fails()) {
            return \Redirect::back()
                ->withErrors($validator)
                ->withInput(\Input::all());
        }else{
            if(!$title = Settings::where('name', '=', 'siteTitle')->first()) {
                Settings::create([
                    'name' => 'siteTitle',
                    'value' => \Input::get('siteTitle')
                ]);
            }else{
                $title->value = \Input::get('siteTitle');
                $title->save();
            }

            if(!$tagline = Settings::where('name', '=', 'siteTagline')->first()) {
                Settings::create([
                    'name' => 'siteTagline',
                    'value' => \Input::get('siteTagline')
                ]);
            }else{
                $tagline->value = \Input::get('siteTagline');
                $tagline->save();
            }

            if(!$ga = Settings::where('name', '=', 'siteGA')->first()) {
                Settings::create([
                    'name' => 'siteGA',
                    'value' => \Input::get('siteGA')
                ]);
            }else{
                $ga->value = \Input::get('siteGA');
                $ga->save();
            }

            if(!$date = Settings::where('name', '=', 'siteDate')->first()) {
                if(\Input::get('dateFormat') != 'custom') {
                    Settings::create([
                        'name' => 'siteDate',
                        'value' => \Input::get('dateFormat')
                    ]);
                }else{
                    Settings::create([
                        'name' => 'siteDate',
                        'value' => \Input::get('dateCustom')
                    ]);
                }
            }else{
                if(\Input::get('dateFormat') != 'custom') {
                    $date->value = \Input::get('dateFormat');
                }else{
                    $date->value = \Input::get('dateCustom');
                }
                $date->save();
            }

            if(!$date = Settings::where('name', '=', 'siteTime')->first()) {
                if(\Input::get('timeFormat') != 'custom') {
                    Settings::create([
                        'name' => 'siteTime',
                        'value' => \Input::get('timeFormat')
                    ]);
                }else{
                    Settings::create([
                        'name' => 'siteTime',
                        'value' => \Input::get('timeCustom')
                    ]);
                }
            }else{
                if(\Input::get('timeFormat') != 'custom') {
                    $date->value = \Input::get('timeFormat');
                }else{
                    $date->value = \Input::get('timeCustom');
                }
                $date->save();
            }
            return \Redirect::to('installation/media');
        }
    }

    /**
     * Media Configuration page
     *
     */
    public function media()
    {
        $nccmsPath = base_path() . '/nccms';
        if(is_dir($nccmsPath) == false){
            return \Redirect::to('installation/init');
        }
        $this->layout->title = 'Media Configuration';
        $this->layout->content = \View::make('nccms::install.setMedia')
            ->with('media', Settings::getMedia())
            ->with('title', 'Media Configuration');
    }

    /**
     * Media action handler
     * @return redirect
     */
    public function doMedia(){
        $rules = array(
            'mediaThumbW' => 'required|min:1',
            'mediaThumbH' => 'required|min:1',
            'mediumW' => 'required|min:1',
            'mediumH' => 'required|min:1',
        );
        $display = array(
            'mediaThumbW' => 'Thumbnail Width',
            'mediaThumbH' => 'Thumbnail Height',
            'mediumW' => 'Max Medium Size Image Width',
            'mediumH' => 'Max Medium Size Image Height',
        );

        $validator = \Validator::make(\Input::all(), $rules, array(), $display);
        if($validator->fails()) {
            return \Redirect::back()
                ->withErrors($validator)
                ->withInput(\Input::all());
        }else{
            if(!$thumbW = Settings::where('name', '=', 'mediaThumbWidth')->first()) {
                Settings::create([
                    'name' => 'mediaThumbWidth',
                    'value' => \Input::get('mediaThumbW')
                ]);
            }else{
                $thumbW->value = \Input::get('mediaThumbW');
                $thumbW->save();
            }

            if(!$thumbH = Settings::where('name', '=', 'mediaThumbHeight')->first()) {
                Settings::create([
                    'name' => 'mediaThumbHeight',
                    'value' => \Input::get('mediaThumbH')
                ]);
            }else{
                $thumbH->value = \Input::get('mediaThumbH');
                $thumbH->save();
            }

            if(!$mediumW = Settings::where('name', '=', 'mediaMediumWidth')->first()) {
                Settings::create([
                    'name' => 'mediaMediumWidth',
                    'value' => \Input::get('mediumW')
                ]);
            }else{
                $mediumW->value = \Input::get('mediumW');
                $mediumW->save();
            }

            if(!$mediumH = Settings::where('name', '=', 'mediaMediumHeight')->first()) {
                Settings::create([
                    'name' => 'mediaMediumHeight',
                    'value' => \Input::get('mediumH')
                ]);
            }else{
                $mediumH->value = \Input::get('mediumH');
                $mediumH->save();
            }

            if(!$theme = Settings::where('name', '=', 'activeTheme')->first()) {
                Settings::create([
                    'name' => 'activeTheme',
                    'value' => 'waldo'
                ]);
            }else{
                $theme->value = 'waldo';
                $theme->save();
            }

            return \Redirect::to('installation/application');
        }
    }

    /**
     * Application Configuration page
     *
     */
    public function app()
    {
        $nccmsPath = base_path() . '/nccms';
        if(is_dir($nccmsPath) == false){
            return \Redirect::to('installation/init');
        }
        $app = \Config::get('app');
        $timezone_identifiers = \DateTimeZone::listIdentifiers();
        $this->layout->title = 'Application Configuration';
        $this->layout->content = \View::make('nccms::install.setConfig')
            ->with('title', 'Application Configuration')
            ->with('timezones', $timezone_identifiers)
            ->with('config', $app);
    }

    /**
     * Application Configuration action
     *
     */
    public function doApp()
    {
        $rules = array(
            'debug' => 'required',
            'url' => 'required|url',
            'timezone' => 'required',
            'eKey' => 'required',
            'prefix' => 'required',
        );
        $display = array(
            'debug' => 'Debug Mode',
            'url' => 'Site URL',
            'timezone' => 'Site Timezone',
            'eKey' => 'Encription Key',
            'prefix' => 'Encription Key',
        );

        $validator = \Validator::make(\Input::all(), $rules, array(), $display);
        if($validator->fails()) {
            return \Redirect::back()
                ->withErrors($validator)
                ->withInput(\Input::all());
        }else{
            Session::put('debug', Input::get('debug'));
            Session::put('url', Input::get('url'));
            Session::put('timezone', Input::get('timezone'));
            Session::put('eKey', Input::get('eKey'));
            Session::put('prefix', strtolower(Input::get('prefix')));
            return \Redirect::to('installation/publish');
        }
    }

    /**
     * Publish Page
     */
    public function publishing()
    {
        return \View::make('nccms::install.publish');
    }

    /**
     * Publish Action
     */
    public function publishNCCMS()
    {
        Artisan::call('asset:publish', ['package' => 'ngungut/nccms']);
        Artisan::call('config:publish', ['package' => 'ngungut/nccms']);
        Artisan::call('config:publish', ['package' => 'ceesvanegmond/minify']);

        $newConfig = "<?php \n\n
return array(

    'installed' => true,
    'route' => '".Session::get('prefix')."',
    'group' => 'prefix',

);";

        $nccmsConfig = app_path() . '/config/packages/ngungut/nccms/nccms.php';
        file_put_contents($nccmsConfig, $newConfig);

        $minifyConfig = "<?php \n\n
return array(

    'ignore_environments' => ['home'],
    'css_build_path' => '/themes/'.\\Nccms::getActiveTheme().'/builds/',
    'js_build_path' => '/themes/'.\\Nccms::getActiveTheme().'/builds/',

);";
        $minConfig = app_path() . '/config/packages/ceesvanegmond/minify/config.php';
        file_put_contents($minConfig, $minifyConfig);

        $appConfig = "<?php \n\n
return array(

	/*
	|--------------------------------------------------------------------------
	| Application Debug Mode
	|--------------------------------------------------------------------------
	|
	| When your application is in debug mode, detailed error messages with
	| stack traces will be shown on every error that occurs within your
	| application. If disabled, a simple generic error page is shown.
	|
	*/

	'debug' => ".Session::get('debug').",

	/*
	|--------------------------------------------------------------------------
	| Application URL
	|--------------------------------------------------------------------------
	|
	| This URL is used by the console to properly generate URLs when using
	| the Artisan command line tool. You should set this to the root of
	| your application so that it is used when running Artisan tasks.
	|
	*/

	'url' => '".Session::get('url')."',

	/*
	|--------------------------------------------------------------------------
	| Application Timezone
	|--------------------------------------------------------------------------
	|
	| Here you may specify the default timezone for your application, which
	| will be used by the PHP date and date-time functions. We have gone
	| ahead and set this to a sensible default for you out of the box.
	|
	*/

	'timezone' => '".Session::get('timezone')."',

	/*
	|--------------------------------------------------------------------------
	| Application Locale Configuration
	|--------------------------------------------------------------------------
	|
	| The application locale determines the default locale that will be used
	| by the translation service provider. You are free to set this value
	| to any of the locales which will be supported by the application.
	|
	*/

	'locale' => 'en',

	/*
	|--------------------------------------------------------------------------
	| Application Fallback Locale
	|--------------------------------------------------------------------------
	|
	| The fallback locale determines the locale to use when the current one
	| is not available. You may change the value to correspond to any of
	| the language folders that are provided through your application.
	|
	*/

	'fallback_locale' => 'en',

	/*
	|--------------------------------------------------------------------------
	| Encryption Key
	|--------------------------------------------------------------------------
	|
	| This key is used by the Illuminate encrypter service and should be set
	| to a random, 32 character string, otherwise these encrypted strings
	| will not be safe. Please do this before deploying an application!
	|
	*/

	'key' => '".Session::get('eKey')."',

	'cipher' => MCRYPT_RIJNDAEL_128,

	/*
	|--------------------------------------------------------------------------
	| Autoloaded Service Providers
	|--------------------------------------------------------------------------
	|
	| The service providers listed here will be automatically loaded on the
	| request to your application. Feel free to add your own services to
	| this array to grant expanded functionality to your applications.
	|
	*/

	'providers' => array(

		'Illuminate\\Foundation\\Providers\\ArtisanServiceProvider',
		'Illuminate\\Auth\\AuthServiceProvider',
		'Illuminate\\Cache\\CacheServiceProvider',
		'Illuminate\\Session\\CommandsServiceProvider',
		'Illuminate\\Foundation\\Providers\\ConsoleSupportServiceProvider',
		'Illuminate\\Routing\\ControllerServiceProvider',
		'Illuminate\\Cookie\\CookieServiceProvider',
		'Illuminate\\Database\\DatabaseServiceProvider',
		'Illuminate\\Encryption\\EncryptionServiceProvider',
		'Illuminate\\Filesystem\\FilesystemServiceProvider',
		'Illuminate\\Hashing\\HashServiceProvider',
		'Illuminate\\Html\\HtmlServiceProvider',
		'Illuminate\\Log\\LogServiceProvider',
		'Illuminate\\Mail\\MailServiceProvider',
		'Illuminate\\Database\\MigrationServiceProvider',
		'Illuminate\\Pagination\\PaginationServiceProvider',
		'Illuminate\\Queue\\QueueServiceProvider',
		'Illuminate\\Redis\\RedisServiceProvider',
		'Illuminate\\Remote\\RemoteServiceProvider',
		'Illuminate\\Auth\\Reminders\\ReminderServiceProvider',
		'Illuminate\\Database\\SeedServiceProvider',
		'Illuminate\\Session\\SessionServiceProvider',
		'Illuminate\\Translation\\TranslationServiceProvider',
		'Illuminate\\Validation\\ValidationServiceProvider',
		'Illuminate\\View\\ViewServiceProvider',
		'Illuminate\\Workbench\\WorkbenchServiceProvider',
		'Ngungut\\Nccms\\NccmsServiceProvider',
		'Ngungut\\Nccms\\PluginServiceProvider',

	),

	/*
	|--------------------------------------------------------------------------
	| Service Provider Manifest
	|--------------------------------------------------------------------------
	|
	| The service provider manifest is used by Laravel to lazy load service
	| providers which are not needed for each request, as well to keep a
	| list of all of the services. Here, you may set its storage spot.
	|
	*/

	'manifest' => storage_path().'/meta',

	/*
	|--------------------------------------------------------------------------
	| Class Aliases
	|--------------------------------------------------------------------------
	|
	| This array of class aliases will be registered when this application
	| is started. However, feel free to register as many as you wish as
	| the aliases are 'lazy' loaded so they don't hinder performance.
	|
	*/

	'aliases' => array(

		'App'               => 'Illuminate\\Support\\Facades\\App',
		'Artisan'           => 'Illuminate\\Support\\Facades\\Artisan',
		'Auth'              => 'Illuminate\\Support\\Facades\\Auth',
		'Blade'             => 'Illuminate\\Support\\Facades\\Blade',
		'Cache'             => 'Illuminate\\Support\\Facades\\Cache',
		'ClassLoader'       => 'Illuminate\\Support\\ClassLoader',
		'Config'            => 'Illuminate\\Support\\Facades\\Config',
		'Controller'        => 'Illuminate\\Routing\\Controller',
		'Cookie'            => 'Illuminate\\Support\\Facades\\Cookie',
		'Crypt'             => 'Illuminate\\Support\\Facades\\Crypt',
		'DB'                => 'Illuminate\\Support\\Facades\\DB',
		'Eloquent'          => 'Illuminate\\Database\\Eloquent\\Model',
		'Event'             => 'Illuminate\\Support\\Facades\\Event',
		'File'              => 'Illuminate\\Support\\Facades\\File',
		'Form'              => 'Illuminate\\Support\\Facades\\Form',
		'Hash'              => 'Illuminate\\Support\\Facades\\Hash',
		'HTML'              => 'Illuminate\\Support\\Facades\\HTML',
		'Input'             => 'Illuminate\\Support\\Facades\\Input',
		'Lang'              => 'Illuminate\\Support\\Facades\\Lang',
		'Log'               => 'Illuminate\\Support\\Facades\\Log',
		'Mail'              => 'Illuminate\\Support\\Facades\\Mail',
		'Paginator'         => 'Illuminate\\Support\\Facades\\Paginator',
		'Password'          => 'Illuminate\\Support\\Facades\\Password',
		'Queue'             => 'Illuminate\\Support\\Facades\\Queue',
		'Redirect'          => 'Illuminate\\Support\\Facades\\Redirect',
		'Redis'             => 'Illuminate\\Support\\Facades\\Redis',
		'Request'           => 'Illuminate\\Support\\Facades\\Request',
		'Response'          => 'Illuminate\\Support\\Facades\\Response',
		'Route'             => 'Illuminate\\Support\\Facades\\Route',
		'Schema'            => 'Illuminate\\Support\\Facades\\Schema',
		'Seeder'            => 'Illuminate\\Database\\Seeder',
		'Session'           => 'Illuminate\\Support\\Facades\\Session',
		'SoftDeletingTrait' => 'Illuminate\\Database\\Eloquent\\SoftDeletingTrait',
		'SSH'               => 'Illuminate\\Support\\Facades\\SSH',
		'Str'               => 'Illuminate\\Support\\Str',
		'URL'               => 'Illuminate\\Support\\Facades\\URL',
		'Validator'         => 'Illuminate\\Support\\Facades\\Validator',
		'View'              => 'Illuminate\\Support\\Facades\\View',

	),

);";

        $appPath = app_path() . '/config/app.php';
        file_put_contents($appPath, $appConfig);
        $resp = \URL::to(Session::get('prefix'));
        \Minify::stylesheetDir('/themes/waldo/css/');
        \Minify::javascriptDir('/themes/waldo/js/');
        Session::forget('debug');
        Session::forget('url');
        Session::forget('timezone');
        Session::forget('eKey');
        Session::forget('prefix');
        return \Response::json(['next' => $resp]);
    }

}
