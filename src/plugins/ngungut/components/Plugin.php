<?php namespace Ngungut\Components;

use Ngungut\Nccms\PluginCore;

class Plugin extends PluginCore {

    public function pluginDetails()
    {
        return [
            'name' => 'Components',
            'description' => 'NCCMS Default Components.',
            'author' => 'ngungut'
        ];
    }

    public function registerComponents()
    {
        return [
            '\Ngungut\Components\Controller\Components\showTitle' => [
                'name' => 'Title',
                'description' => 'Show Page/Post Title',
                'author' => 'ngungut',
                'nameSpace' => '\Ngungut\Components',
                'handler' => '\Ngungut\Components\Controller\Components',
                'action' => 'showTitle'
            ],
            '\Ngungut\Components\Controller\Components\showContent' => [
                'name' => 'Content',
                'description' => 'Show Page/Post Content',
                'author' => 'ngungut',
                'nameSpace' => '\Ngungut\Components',
                'handler' => '\Ngungut\Components\Controller\Components',
                'action' => 'showContent'
            ],
            '\Ngungut\Components\Controller\Components\showExcerpt' => [
                'name' => 'Excerpt',
                'description' => 'Show Page/Post Excerpt',
                'author' => 'ngungut',
                'nameSpace' => '\Ngungut\Components',
                'handler' => '\Ngungut\Components\Controller\Components',
                'action' => 'showExcerpt'
            ],
            '\Ngungut\Components\Controller\Components\showImage' => [
                'name' => 'Feature Image',
                'description' => 'Show Page/Post Feature Image',
                'author' => 'ngungut',
                'nameSpace' => '\Ngungut\Components',
                'handler' => '\Ngungut\Components\Controller\Components',
                'action' => 'showImage'
            ],
            '\Ngungut\Components\Controller\Components\showDate' => [
                'name' => 'Create Date',
                'description' => 'Show Page/Post Creation Date',
                'author' => 'ngungut',
                'nameSpace' => '\Ngungut\Components',
                'handler' => '\Ngungut\Components\Controller\Components',
                'action' => 'showDate'
            ],
            '\Ngungut\Components\Controller\Components\categoryList' => [
                'name' => 'Category List',
                'description' => 'Display List of Category',
                'author' => 'ngungut',
                'nameSpace' => '\Ngungut\Components',
                'handler' => '\Ngungut\Components\Controller\Components',
                'action' => 'categoryList'
            ],
            '\Ngungut\Components\Controller\Components\recentPost' => [
                'name' => 'Recent Post',
                'description' => 'Display Recent Post List of Category',
                'author' => 'ngungut',
                'options' => [
                    'handler' => '\Ngungut\Components\Controller\Components',
                    'action' => 'getList'
                ],
                'nameSpace' => '\Ngungut\Components',
                'handler' => '\Ngungut\Components\Controller\Components',
                'action' => 'recentPost'
            ],
            '\Ngungut\Components\Controller\Components\categoryPost' => [
                'name' => 'Category Post',
                'description' => 'Display Post List of Category',
                'author' => 'ngungut',
                'options' => [
                    'handler' => '\Ngungut\Components\Controller\Components',
                    'action' => 'getList'
                ],
                'nameSpace' => '\Ngungut\Components',
                'handler' => '\Ngungut\Components\Controller\Components',
                'action' => 'categoryPost'
            ],
        ];
    }

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        //load all controller file
        foreach (glob(__DIR__.'/controllers/*.php') as $filename)
        {
            include $filename;
        }

        //add location of plugin views
        \View::addLocation(base_path().'/nccms/plugins/ngungut/components/views');

        //set namespace for plugin views
        \View::addNamespace('component', base_path().'/nccms/plugins/ngungut/components/views');
    }
}