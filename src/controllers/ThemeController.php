<?php namespace Ngungut\Nccms\Controller;

use BaseController;
use Ngungut\Nccms\Model\Settings;

/**
 * Class MenuController
 * Contain Menu Handler
 */
class ThemeController extends BaseController {
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
        $themes = \ThemesManager::getThemes() ;
        $this->layout->title = 'Themes - NCCMS';
        $this->layout->with('script', 'nccms::admin.themes.scripts.action')
            ->with('style', 'nccms::admin.themes.styles.action');
        $this->layout->content = \View::make('nccms::admin.themes.action')
            ->with('title', 'Themes')
            ->with('themes', $themes);
	}

    public function doThemes(){
        $rules = array(
            'theme' => 'required|max:60',
        );
        $display = array(
            'theme' => 'Theme Name',
        );

        $validator = \Validator::make(\Input::all(), $rules, array(), $display);
        if($validator->fails()) {
            return \Redirect::back()
                ->withErrors($validator)
                ->withInput(\Input::all());
        }else{
            if(is_dir(base_path() . '/nccms/themes/' . \Input::get('theme'))){
                if(!$theme = Settings::where('name', '=', 'activeTheme')->first()) {
                    Settings::create([
                        'name' => 'activeTheme',
                        'value' => \Input::get('theme')
                    ]);
                }else{
                    $theme->value = \Input::get('theme');
                    $theme->save();
                }
            }
            return \Redirect::nccms('themes');
        }
    }

}