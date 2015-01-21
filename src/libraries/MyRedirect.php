<?php namespace Ngungut\Nccms\Libraries;

use \Illuminate\Routing\Redirector;

class MyRedirect extends Redirector {

    public function nccms($string){
        $group = \Config::get('nccms::nccms.group');
        $route = \Config::get('nccms::nccms.route');
        if($group == 'prefix'){
            return $this->to($route . '/' . $string);
        }else{
            return $this->to($string);
        }
    }
    
}
