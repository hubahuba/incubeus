<?php namespace Ngungut\Nccms;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Ngungut\Nccms\Facades\Common;
use Ngungut\Nccms\Model\Posts;
use Ngungut\Nccms\Model\Settings;
use Ngungut\Nccms\Model\Categories;

class Nccms {

    protected $pageData;

    public function __construct(){
        $this->themesPath = \Config::get('nccms::path.themes');
        $this->activeTheme = rtrim(self::getActiveTheme(), '/') . '/';
    }
    /**
     * Nccms Template Handler and Drawing The page
     * @param string $slug
     */
    public function draw($url = ''){
        $url = \Request::segment(1);
        if(!$url) $url = \Request::path();
        $page = Posts::where('slug', '=', $url)
            ->where('status', '=', 'pub')
            ->whereRaw('publish_date <= NOW()')
            ->orderBy('updated_at')->first();
        if(isset($page->id)){
            $this->pageData = $page;
            $template = $page->template;
            $exp = explode('.', $template);
            if($cate = \Request::segment(2)){
                if(!is_int($cate)) {
                    $cat = Categories::where('slug', '=', $cate)->first();
                    $this->pageData['title'] = $cat['name'];
                }
            }
            return $this->template($exp[0]);
        }
        $this->pageData = ['title' => 'Page not found.'];
        return $this->template('404');
    }

    public function partial($file){
        return \View::make('partial::'.$file)
            ->with('data', $this->pageData)
            ->render();
    }

    public function menu($file){
        return \View::make('menu::'.$file)
            ->with('data', $this->pageData)
            ->render();
    }

    public function template($file){
        return \View::make('template::'.$file)
            ->with('data', $this->pageData)
            ->render();
    }

    public function getPartials(){
        $partials = [];
        foreach(glob($this->themesPath . $this->activeTheme . 'partials/' . '*.php') as $partial){
            $explode = explode('.', basename($partial));
            $partials[basename($partial)] = \Str::title(reset($explode));
        }
        return $partials;
    }

    public function getMenus(){
        $menus = [];
        foreach(glob($this->themesPath . $this->activeTheme . 'menus/' . '*.php') as $menu){
            $explode = explode('.', basename($menu));
            $menus[basename($menu)] = Format::slugToText(reset($explode));
        }
        return $menus;
    }

    public function getTemplates(){
        $templates = [];
        foreach(glob($this->themesPath . $this->activeTheme . 'templates/' . '*.php') as $template){
            $explode = explode('.', basename($template));
            $templates[basename($template)] = Format::slugToText(reset($explode));
        }
        return $templates;
    }

    public function getComponent(){
        $plugins = PluginManager::instance();
        $component = [];
        foreach($plugins->getPlugins() as $plugin){
            $components = $plugin->registerComponents();
            if(!empty($components)){
                foreach($components as $key => $val) {
                    $options = '';
                    if(isset($val['options'])){
                        $action = $val['options']['action'];
                        $options = \App::make($val['options']['handler'])->{$action}();
                    }
                    $component[] = [
                        'action' => $val['action'],
                        'handler' => $val['handler'],
                        'name' => $val['name'],
                        'description' => $val['description'],
                        'author' => $val['author'],
                        'options' => isset($options) ? $options:''
                    ];
                }
            }
        }
        return $component;
    }

    public function getAssetContainer($folder = false){
        $base = false;
        $basePath = base_path() . '/nccms/themes/' . $this->activeTheme . '/assets';
        $basePath = realpath($basePath);
        if($folder) {
            if (Session::has('currentFolder')) {
                $path = Session::get('currentFolder') . '/' . $folder;
            }else{
                $path = $basePath . '/' . $folder;
            }
            $realFolder = realpath($path);
            if($realFolder == $basePath){
                $base = true;
                Session::forget('currentFolder');
            }else {
                Session::put('currentFolder', realpath($path));
            }
        }else{
            if (Session::has('currentFolder')) {
                $path = Session::get('currentFolder');
            }else{
                $path = $basePath;
            }
            $realFolder = realpath($path);
            if($realFolder == $basePath){
                $base = true;
            }
        }
        $files = array_map('basename', File::files($path));
        $dirs = array_map('basename', File::directories($path));
        $inside = [
            'files' => $files,
            'dirs' => $dirs,
            'base' => $base
        ];
        return $inside;
    }

    public function getByExt($ext){
        $base = false;
        $path = public_path() . '/themes/' . $this->activeTheme;
        $files = \File::allFiles($path);
        $specificFile = [];
        foreach($files as $file){
            if(\File::extension($file->getFilename()) == $ext){
                $path = $path = str_replace(array('\\', '/'), '/', 'themes/' . $this->activeTheme . $file->getRelativePathname());
                $specificFile[$path] = $file->getFilename();
            }
        }
        return $specificFile;
    }

    public function getMedia(){
        $media = Settings::where('name', 'LIKE', 'media%')->get();
        $return = [];
        foreach($media as $resp){
            $return[$resp['name']] = $resp['value'];
        }
        return $return;
    }

    public function getThumbW(){
        $media = Settings::where('name', '=', 'mediaThumbWidth')->first();
        if(isset($media->id)) {
            $return = $media['value'];
        }else{
            $return = 1;
        }
        return $return;
    }

    public function getThumbH(){
        $media = Settings::where('name', '=', 'mediaThumbHeight')->first();
        if(isset($media->id)) {
            $return = $media['value'];
        }else{
            $return = 1;
        }
        return $return;
    }

    public function getMediumW(){
        $media = Settings::where('name', '=', 'mediaMediumWidth')->first();
        if(isset($media->id)) {
            $return = $media['value'];
        }else{
            $return = 1;
        }
        return $return;
    }

    public function getMediumH(){
        $media = Settings::where('name', '=', 'mediaMediumHeight')->first();
        if(isset($media->id)) {
            $return = $media['value'];
        }else{
            $return = 1;
        }
        return $return;
    }

    public function getLargeW(){
        $media = Settings::where('name', '=', 'mediaLargeWidth')->first();
        if(isset($media->id)) {
            $return = $media['value'];
        }else{
            $return = 1;
        }
        return $return;
    }

    public function getLargeH(){
        $media = Settings::where('name', '=', 'mediaLargeHeight')->first();
        if(isset($media->id)) {
            $return = $media['value'];
        }else{
            $return = 1;
        }
        return $return;
    }

    public function getSite(){
        $media = Settings::where('name', 'LIKE', 'site%')->get();
        $return = [];
        foreach($media as $resp){
            $return[$resp['name']] = $resp['value'];
        }
        return $return;
    }

    public function getTitle(){
        $site = Settings::where('name', '=', 'siteTitle')->first();
        if(isset($site->id)) {
            $return = $site['value'];
        }else{
            $return = 'NCCMS';
        }
        return $return;
    }

    public function getTagline(){
        $site = Settings::where('name', '=', 'siteTagline')->first();
        if(isset($site->id)) {
            $return = $site['value'];
        }else{
            $return = 'CMS Made By Narrada Communication';
        }
        return $return;
    }

    public function getWebDateFormat(){
        $date = Settings::where('name', '=', 'siteDate')->first();
        $time = Settings::where('name', '=', 'siteTime')->first();
        if(isset($date->id) && isset($time->id)) {
            $return = $date . ' @ ' . $time;
        }else{
            $return = 'F j, Y @ H:i:s';
        }
        return $return;
    }

    public function getGA(){
        $site = Settings::where('name', '=', 'siteGA')->first();
        if(isset($site->id)) {
            $return = $site['value'];
        }else{
            $return = false;
        }
        return $return;
    }

    public static function getActiveTheme(){
        $site = Settings::where('name', '=', 'activeTheme')->first();
        if(isset($site->id)) {
            $return = $site['value'];
        }else{
            $return = false;
        }
        return $return;
    }
}