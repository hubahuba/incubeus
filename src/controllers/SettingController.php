<?php namespace Ngungut\Nccms\Controller;

use BaseController;
use Ngungut\Nccms\Libraries\Common;
use Ngungut\Nccms\Model\Settings;

/**
 * Class SettingController
 * Contain all setting Handler
 */
class SettingController extends BaseController {
    /**
     * set default layout
     * @var string
     */
    protected $layout = 'nccms::layouts.admin';

    /**
     * Setting Default page
     */
	public function index()
    {
        $title = 'Website Setting';
        $this->layout->title = $title . ' - NCCMS';
        $this->layout->with('script', 'nccms::admin.setting.scripts.general')
            ->with('style', 'nccms::admin.setting.styles.general');
        $this->layout->content = \View::make('nccms::admin.setting.general')
            ->with('media', Settings::getMedia())
            ->with('site', Settings::getSite())
            ->with('title', $title);
	}

    /**
     * Ajax date/time Format date handler
     * @return json
     */
    public function formater(){
        $date = date(\Input::get('format'));
        if($date){
            return \Response::json(['success' => $date]);
        }else{
            return \Response::json(['failed' => true]);
        }
    }

    /**
     * General Setting action handler
     * @return redirect
     */
    public function general(){
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
            return \Redirect::nccms('setting');
        }
    }

    /**
     * Setting Media action handler
     * @return redirect
     */
    public function media(){
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
            return \Redirect::nccms('setting')
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
            return \Redirect::nccms('setting');
        }
    }

}
