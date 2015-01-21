<?php namespace Ngungut\Nccms\Controller;

use BaseController;
use Illuminate\Support\Facades\URL;
use Ngungut\Nccms\Facades\Nccms;
use Ngungut\Nccms\Facades\Common;
use Ngungut\Nccms\Facades\Format;
use Ngungut\Nccms\Model\MenuDetail;
use Ngungut\Nccms\Model\Menus;
use Ngungut\Nccms\Model\Posts;
use Ngungut\Nccms\Model\Settings;
use Ngungut\Nccms\PluginManager;
use Ngungut\Nccms\PartialManager;

/**
 * Class MenuController
 * Contain Menu Handler
 */
class MenuController extends BaseController {
    /**
     * set default layout
     * @var string
     */
    protected $layout = 'nccms::layouts.admin';

    /**
     * Menu list page
     * @return void
     */
	public function index()
	{
        /**
         * Get Page List
         */
        $pages = Posts::where('type', '=', 'page')
            ->where('status', '=', 'pub')
            ->whereRaw('publish_date <= NOW()')
            ->orderBy('updated_at')->get();
        /**
         * Get Post List
         */
        $posts = Posts::where('type', '=', 'post')
            ->where('status', '=', 'pub')
            ->whereRaw('publish_date <= NOW()')
            ->orderBy('updated_at')->get();
        $menus = Nccms::getMenus();
        $this->layout->title = 'Menu - NCCMS';
        $this->layout->with('script', 'nccms::admin.menu.scripts.action')
            ->with('style', 'nccms::admin.menu.styles.action');
        $this->layout->content = \View::make('nccms::admin.menu.action')
            ->with('menus', $menus)
            ->with('pages', $pages)
            ->with('posts', $posts)
            ->with('title', 'Menu');
	}

    /**
     * Menu Save Action
     */
    public function action(){
        $rules = array(
            'label' => 'required|max:60',
            'content' => 'required',
        );
        $display = array(
            'label' => 'Menu Label Name',
            'content' => 'Menu Content',
        );

        $validator = \Validator::make(\Input::all(), $rules, array(), $display);
        if($validator->fails()) {
            return \Response::json([
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()
            ]);
        }else{
            $themesPath = \Config::get('nccms::path.themes');
            $activeTheme = rtrim(Settings::getActiveTheme(), '/') . '/';
            $fullPath = $themesPath . $activeTheme . 'menus/';
            $file = Format::textToSlug(\Input::get('label'));
            $filename = $file.'.blade.php';
            $create = \File::put($fullPath . $filename, \Input::get('content'));
            if($create) {
                return \Response::json([
                    'success' => true,
                ]);
            }else{
                return \Response::json([
                    'success' => false,
                    'errors' => 'Fail to create menu file, please check you\'re folder permission.'
                ]);
            }
        }
    }

    /**
     * Get Menu for editing
     */
    public function getMenu(){
        $rules = array(
            'file' => 'required',
        );
        $display = array(
            'file' => 'Menu Name',
        );

        $validator = \Validator::make(\Input::all(), $rules, array(), $display);
        if($validator->fails()) {
            return \Response::json([
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()
            ]);
        }else{
            $themesPath = \Config::get('nccms::path.themes');
            $activeTheme = rtrim(Settings::getActiveTheme(), '/') . '/';
            $fullPath = $themesPath . $activeTheme . 'menus/';
            $file = Format::textToSlug(\Input::get('file'));
            $filename = $file.'.blade.php';
            $content = \File::get($fullPath . $filename);
            if($content) {
                return \Response::json([
                    'success' => true,
                    'content' => $content
                ]);
            }else{
                return \Response::json([
                    'success' => false,
                    'errors' => 'Can\'t read menu content, please check you\'re folder permission.'
                ]);
            }
        }
    }

    /**
     * Delete Menu action
     */
    public function delMenu(){
        $rules = array(
            'file' => 'required',
        );
        $display = array(
            'file' => 'Menu Name',
        );

        $validator = \Validator::make(\Input::all(), $rules, array(), $display);
        if($validator->fails()) {
            return \Response::json([
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()
            ]);
        }else{
            $themesPath = \Config::get('nccms::path.themes');
            $activeTheme = rtrim(Settings::getActiveTheme(), '/') . '/';
            $fullPath = $themesPath . $activeTheme . 'menus/';
            $file = Format::textToSlug(\Input::get('file'));
            $filename = $file.'.blade.php';
            $del = \File::delete($fullPath . $filename);
            if($del) {
                return \Response::json([
                    'success' => true
                ]);
            }else{
                return \Response::json([
                    'success' => false,
                    'errors' => 'Can\'t remove this menu file, please check you\'re folder permission.'
                ]);
            }
        }
    }

}