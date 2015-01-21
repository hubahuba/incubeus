<?php namespace Ngungut\Nccms\Controller;

use BaseController;
use CeesVanEgmond\Minify\Facades\Minify;
use Illuminate\Support\Facades\Session;
use Ngungut\Nccms\Facades\Nccms;
use Ngungut\Nccms\Model\Posts;
use Ngungut\Nccms\Model\Settings;
use Ngungut\Nccms\PluginManager;

/**
 * Class MenuController
 * Contain Menu Handler
 */
class AssetController extends BaseController {
    /**
     * set default layout
     * @var string
     */
    protected $layout = 'nccms::layouts.admin';

    /**
     * Asset Action page
     * @return void
     */
	public function index()
	{
        Session::forget('currentFolder');
        $files = Nccms::getAssetContainer();
        $this->layout->title = 'Partial - NCCMS';
        $this->layout->with('script', 'nccms::admin.asset.scripts.action')
            ->with('style', 'nccms::admin.asset.styles.action');
        $this->layout->content = \View::make('nccms::admin.asset.action')
            ->with('files', $files)
            ->with('title', 'Partial');
	}

    /**
     * Asset Pubish Action
     * @return void
     */
    public function publishAsset()
    {
        $path = \Config::get('nccms::path.themes');
        $activeTheme = \Nccms::getActiveTheme();
        $privPath = $path . $activeTheme . '/assets/';
        $scssPath = $privPath . 'build/';
        $distPath = $privPath . 'css/';
        if(!is_dir($distPath)){
            mkdir($distPath);
        }
        //compile scss file
        if(is_dir($scssPath) && (count(scandir($scssPath)) > 2)){
            $scss_compiler = new \scssc();
            $scss_compiler->setImportPaths($scssPath);
            $scss_compiler->setFormatter('scss_formatter_nested');
            $filelist = glob($scssPath . "*.scss");
            foreach ($filelist as $file_path) {
                $file_path_elements = pathinfo($file_path);
                $file_name = $file_path_elements['filename'];
                $string_scss = file_get_contents($scssPath . $file_name . ".scss");
                $string_css = $scss_compiler->compile($string_scss);
                file_put_contents($distPath . $file_name . ".css", $string_css);
            }
        }
        //copy to public html folder
        $public = public_path();
        $pubTheme = $public . '/themes/' . $activeTheme;
        if(!is_dir($pubTheme)){
            mkdir($pubTheme);
        }
        \File::copyDirectory($privPath, $pubTheme);
        //remove build folder
        \File::deleteDirectory($pubTheme . '/build');
        //min dir
        $min = $public . '/themes/' . $activeTheme . '/builds';
        if(!is_dir($min)){
            mkdir($min);
        }
        Minify::stylesheetDir('/themes/' . $activeTheme . '/css/');
        Minify::javascriptDir('/themes/' . $activeTheme . '/js/');
        return \Response::json([
            'success' => true
        ]);
    }

    /**
     * Change dir Action page
     * @return void
     */
    public function changeDir()
    {
        $rules = array(
            'folder' => 'required',
        );
        $display = array(
            'folder' => 'Folder Name',
        );

        $validator = \Validator::make(\Input::all(), $rules, array(), $display);
        if($validator->fails()) {
            return \Response::json([
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()
            ]);
        }else{
            $files = Nccms::getAssetContainer(\Input::get('folder'));
            $next = $this->genFiles($files);
            if($next) {
                return \Response::json([
                    'success' => true,
                    'next' => $next->render()
                ]);
            }else{
                return \Response::json([
                    'success' => false,
                    'errors' => 'Fail to read directories and files, please check you\'re folder permission.'
                ]);
            }
        }
    }

    /**
     * Current dir Action page
     * @return void
     */
    public function currentDir()
    {
        $files = Nccms::getAssetContainer();
        $next = $this->genFiles($files);
        if($next) {
            return \Response::json([
                'success' => true,
                'next' => $next->render()
            ]);
        }else{
            return \Response::json([
                'success' => false,
                'errors' => 'Fail to read directories and files, please check you\'re folder permission.'
            ]);
        }
    }

    private function genFiles($files){
        return \View::make('nccms::admin.asset.nextFiles')
            ->with('files', $files);
    }

    /**
     * Partial Save Action
     */
    public function action(){
        $rules = array(
            'label' => 'required',
            'content' => 'required',
        );
        $display = array(
            'label' => 'File Name',
            'content' => 'File Content',
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
            $fullPath = $themesPath . $activeTheme . 'assets/';
            $path = $fullPath . Session::get('currentFolder') . '/' .  \Input::get('label');
            if(Session::has('currentFolder')){
                $path = Session::get('currentFolder') . '/' . \Input::get('label');
            }else {
                $path = $fullPath . '/' . \Input::get('label');
            }
            $create = \File::put($path, \Input::get('content'));
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
    public function getAsset(){
        $rules = array(
            'file' => 'required',
        );
        $display = array(
            'file' => 'File Name',
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
            $fullPath = $themesPath . $activeTheme . 'assets/';
            if(Session::has('currentFolder')){
                $path = Session::get('currentFolder') . '/' . \Input::get('file');
            }else {
                $path = $fullPath  . '/' . \Input::get('file');
            }
            $content = \File::get($path);
            $ext = \File::extension(\Input::get('file'));
            if($content) {
                return \Response::json([
                    'success' => true,
                    'content' => $content,
                    'ext' => ($ext == 'js') ? 'javascript':(($ext == 'css' || $ext == 'scss') ? $ext:'php')
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
    public function delAsset(){
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
            $fullPath = $themesPath . $activeTheme . 'assets/';
            if(Session::has('currentFolder')){
                $path = Session::get('currentFolder') . '/' . \Input::get('file');
            }else {
                $path = $fullPath  . '/' . \Input::get('file');
            }
            $del = \File::delete($path);
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