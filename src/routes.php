<?php

/**
 * Start Router for admin
 *
 */
Route::group(array(Config::get('nccms::nccms.group') => Config::get('nccms::nccms.route'), 'before' => 'isAdmin|isInstall'), function()
{
    /**
     * Route For Dashboard
     */
    Route::get('/', ['uses' => 'AdminController@dashboard']);

    /**
     * Route For Login Page
     */
    Route::get('login', ['uses' => 'AdminController@login']);
    /**
     * Login action Handler
     */
    Route::post('login', [
        'before' => 'csrf',
        'uses' => 'AdminController@doLogin'
    ]);

    /**
     * Route For Logout
     */
    Route::get('logout', ['uses' => 'AdminController@logout']);

    /**
     * Route For Post
     */
    Route::group(array('prefix' => 'post'), function() {
        /**
         * Post List Page
         */
        Route::get('/', ['uses' => 'PostController@index']);
        /**
         * Create new post
         */
        Route::get('new', ['uses' => 'PostController@action']);
        /**
         * New Post Action Handler
         */
        Route::post('new', ['before' => 'csrf', 'uses' => 'PostController@doAction']);
        /**
         * Create new post
         */
        Route::get('edit/{id}', ['uses' => 'PostController@action']);
        /**
         * New Post Action Handler
         */
        Route::post('edit/{id}', ['before' => 'csrf', 'uses' => 'PostController@doAction']);
        /**
         * Category Page Handler
         */
        Route::get('categories', ['uses' => 'CategoryController@index']);
        /**
         * New/Edit Category Post Action Handler
         */
        Route::post('categories', ['before' => 'csrf', 'uses' => 'CategoryController@doCategories']);
        /**
         * delete Page
         */
        Route::get('delete/{id}', ['uses' => 'PostController@delete']);
    });

    /**
     * Route For Page
     */
    Route::group(array('prefix' => 'page'), function() {
        /**
         * Post List Page
         */
        Route::get('/', ['uses' => 'PageController@index']);
        /**
         * Create new post
         */
        Route::get('new', ['uses' => 'PageController@action']);
        /**
         * New Page Action Handler
         */
        Route::post('new', ['before' => 'csrf', 'uses' => 'PageController@doAction']);
        /**
         * Create new Page
         */
        Route::get('edit/{id}', ['uses' => 'PageController@action']);
        /**
         * New Page Action Handler
         */
        Route::post('edit/{id}', ['before' => 'csrf', 'uses' => 'PageController@doAction']);
        /**
         * Category Page Handler
         */
        Route::get('categories', ['uses' => 'CategoryController@index']);
        /**
         * delete Page
         */
        Route::get('delete/{id}', ['uses' => 'PageController@delete']);
    });

    /**
     * Route For Media
     */
    Route::group(array('prefix' => 'media'), function() {
        /**
         * Libraries Page
         */
        Route::get('libraries', ['uses' => 'MediaController@libraries']);
        /**
         * Upload Page
         */
        Route::get('upload', ['uses' => 'MediaController@upload']);
        /**
         * Upload Media action Handler
         */
        Route::post('upload', ['uses' => 'MediaController@doUpload']);
        /**
         * Delete Media action Handler
         */
        Route::get('delete/{id}', ['uses' => 'MediaController@remove']);

        /**
         * CKEDITOR Prefix URL
         */
        Route::group(array('prefix' => 'ckeditor'), function() {
            /**
             * File Libraries Page
             */
            Route::get('libraries', ['uses' => 'CkeditorController@libraries']);
            /**
             * Image Libraries Page
             */
            Route::get('image', ['uses' => 'CkeditorController@image']);
            /**
             * Upload Page
             */
            Route::get('upload', ['uses' => 'CkeditorController@upload']);
            /**
             * Upload Media action Handler
             */
            Route::post('upload', ['uses' => 'CkeditorController@doUpload']);
        });

        /**
         * Feature Image Prefix URL
         */
        Route::group(array('prefix' => 'feature-image'), function() {
            /**
             * Image Libraries Page
             */
            Route::get('/', ['uses' => 'FimageController@image']);
            /**
             * Upload Page
             */
            Route::get('upload', ['uses' => 'FimageController@upload']);
            /**
             * Upload Media action Handler
             */
            Route::post('upload', ['uses' => 'FimageController@doUpload']);
        });
    });

    /**
     * Route For Setting
     */
    Route::group(array('prefix' => 'setting'), function() {
        /**
         * Setting Show Page
         */
        Route::get('/', ['uses' => 'SettingController@index']);
        /**
         * Setting General Action Handler
         */
        Route::post('general', ['uses' => 'SettingController@general']);
        /**
         * Setting Media Action handler
         */
        Route::post('media', ['uses' => 'SettingController@media']);
    });

    /**
     * Route For Menu
     */
    Route::group(array('prefix' => 'menus'), function() {
        /**
         * Menu List Page
         */
        Route::get('/', ['uses' => 'MenuController@index']);
        /**
         * Menu Save Action
         */
        Route::post('/', ['uses' => 'MenuController@action']);
        /**
         * Get Menu File Content
         */
        Route::post('getMenu', ['uses' => 'MenuController@getMenu']);
        /**
         * Delete Menu File
         */
        Route::post('delMenu', ['uses' => 'MenuController@delMenu']);
    });

    /**
     * Route For Partial
     */
    Route::group(array('prefix' => 'partials'), function() {
        /**
         * Menu List Page
         */
        Route::get('/', ['uses' => 'PartialController@index']);
        /**
         * Menu Save Action
         */
        Route::post('/', ['uses' => 'PartialController@action']);
        /**
         * Get Menu File Content
         */
        Route::post('getPartial', ['uses' => 'PartialController@getPartial']);
        /**
         * Delete Menu File
         */
        Route::post('delPartial', ['uses' => 'PartialController@delPartial']);
    });

    /**
     * Route For Asset
     */
    Route::group(array('prefix' => 'assets'), function() {
        /**
         * Asset List Page
         */
        Route::get('/', ['uses' => 'AssetController@index']);
        /**
         * Asset Save Action
         */
        Route::post('/', ['uses' => 'AssetController@action']);
        /**
         * Get Asset File Content
         */
        Route::post('getFile', ['uses' => 'AssetController@getAsset']);
        /**
         * Delete Asset File
         */
        Route::post('delFile', ['uses' => 'AssetController@delAsset']);

        Route::post('change', ['uses' => 'AssetController@changeDir']);

        Route::post('current', ['uses' => 'AssetController@currentDir']);

        Route::get('publish', ['uses' => 'AssetController@publishAsset']);
    });

    /**
     * Route For Template
     */
    Route::group(array('prefix' => 'templates'), function() {
        /**
         * Template List Page
         */
        Route::get('/', ['uses' => 'TemplateController@index']);
        /**
         * Template Save Action
         */
        Route::post('/', ['uses' => 'TemplateController@action']);
        /**
         * Get Template File Content
         */
        Route::post('getTemplate', ['uses' => 'TemplateController@getTemplate']);
        /**
         * Delete Asset File
         */
        Route::post('delTemplate', ['uses' => 'TemplateController@delTemplate']);
    });

    /**
     * Route for admin themes request
     */
    Route::group(['prefix' => 'themes'], function(){
        /**
         * Template List Page
         */
        Route::get('/', ['uses' => 'ThemeController@index']);
        /**
         * New Template Action Page
         */
        Route::post('/', ['uses' => 'ThemeController@doThemes']);
    });

    /**
     * Route for admin user request
     */
    Route::group(['prefix' => 'users'], function(){
        /**
         * Template List Page
         */
        Route::get('/', ['uses' => 'UsersController@index']);
        /**
         * New Template Action Page
         */
        Route::post('/', ['uses' => 'UsersController@doUsers']);
    });

    /**
     * Route for admin ajax request
     */
    Route::group(['prefix' => 'ajax'], function(){
        /**
         * ajax for date/time format
         */
        Route::post('dater', ['uses' => 'SettingController@formater']);
    });

});

/**
 * Installasion URL
 */
Route::group(['prefix' => 'installation', 'before' => 'alreadyInstall'], function()
{
    Route::group(['prefix' => 'init'], function()
    {
        Route::get('/', ['uses' => 'InstallController@initiate']);
        Route::get('folder', ['uses' => 'InstallController@initFolder']);
    });
    Route::get('/', ['uses' => 'InstallController@index']);
    Route::post('/', ['uses' => 'InstallController@doDatabase']);

    Route::get('user', ['uses' => 'InstallController@users']);
    Route::post('user', ['uses' => 'InstallController@doUser']);

    Route::get('setting', ['uses' => 'InstallController@setting']);
    Route::post('setting', ['uses' => 'InstallController@doSetting']);

    Route::get('media', ['uses' => 'InstallController@media']);
    Route::post('media', ['uses' => 'InstallController@doMedia']);

    Route::get('application', ['uses' => 'InstallController@app']);
    Route::post('application', ['uses' => 'InstallController@doApp']);

    Route::group(['prefix' => 'publish'], function()
    {
        Route::get('/', ['uses' => 'InstallController@publishing']);
        Route::get('start', ['uses' => 'InstallController@publishNCCMS']);
    });
});

Route::any('{all}', ['before' => 'isInstall', function($uri)
{
    return Nccms::draw($uri);
}])->where('all', '.*');