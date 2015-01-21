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
class PartialController extends BaseController {
    /**
     * set default layout
     * @var string
     */
    protected $layout = 'nccms::layouts.admin';

    /**
     * Partial list page
     * @return void
     */
	public function index()
	{
        $partials = Nccms::getPartials();
        $css = Nccms::getByExt('css');
        $js = Nccms::getByExt('js');
        $this->layout->title = 'Partial - NCCMS';
        $this->layout->with('script', 'nccms::admin.partial.scripts.action')
            ->with('style', 'nccms::admin.partial.styles.action');
        $this->layout->content = \View::make('nccms::admin.partial.action')
            ->with('partials', $partials)
            ->with('css', $css)
            ->with('js', $js)
            ->with('title', 'Partial');
	}

    /**
     * Partial Save Action
     */
    public function action(){
        $rules = array(
            'label' => 'required|max:60',
            'content' => 'required',
        );
        $display = array(
            'label' => 'Partial Name',
            'content' => 'Partial Content',
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
            $fullPath = $themesPath . $activeTheme . 'partials/';
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
                    'errors' => 'Fail to create partial file, please check you\'re folder permission.'
                ]);
            }
        }
    }

    /**
     * Get Partial for editing
     */
    public function getPartial(){
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
            $fullPath = $themesPath . $activeTheme . 'partials/';
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
                    'errors' => 'Can\'t read partial content, please check you\'re folder permission.'
                ]);
            }
        }
    }

    /**
     * Delete Menu action
     */
    public function delPartial(){
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
            $fullPath = $themesPath . $activeTheme . 'partials/';
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
                    'errors' => 'Can\'t remove this partial file, please check you\'re folder permission.'
                ]);
            }
        }
    }

}