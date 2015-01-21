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
class TemplateController extends BaseController {
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
        $templates = Nccms::getTemplates();
        $partials = Nccms::getPartials();
        $menus = Nccms::getMenus();
        $components = Nccms::getComponent();
        $this->layout->title = 'Template - NCCMS';
        $this->layout->with('script', 'nccms::admin.template.scripts.action')
            ->with('style', 'nccms::admin.template.styles.action');
        $this->layout->content = \View::make('nccms::admin.template.action')
            ->with('templates', $templates)
            ->with('partials', $partials)
            ->with('menus', $menus)
            ->with('components', $components)
            ->with('title', 'Template');
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
            'label' => 'Template Label Name',
            'content' => 'Template Content',
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
            $fullPath = $themesPath . $activeTheme . 'templates/';
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
                    'errors' => 'Fail to create template file, please check you\'re folder permission.'
                ]);
            }
        }
    }

    /**
     * Get Menu for editing
     */
    public function getTemplate(){
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
            $fullPath = $themesPath . $activeTheme . 'templates/';
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
                    'errors' => 'Can\'t read template content, please check you\'re folder permission.'
                ]);
            }
        }
    }

    /**
     * Delete Menu action
     */
    public function delTemplate(){
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
            $fullPath = $themesPath . $activeTheme . 'templates/';
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
                    'errors' => 'Can\'t remove this template file, please check you\'re folder permission.'
                ]);
            }
        }
    }

}