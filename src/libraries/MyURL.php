<?php namespace Ngungut\Nccms\Libraries;

use \Illuminate\Routing\UrlGenerator;
use Ngungut\Nccms\Model\Posts;

class MyURL extends UrlGenerator {

    public function nccms($string){
        $group = \Config::get('nccms::nccms.group');
        $route = \Config::get('nccms::nccms.route');
        if($group == 'prefix'){
            return $this->to($route . '/' . $string);
        }else{
            return $this->to($string);
        }
    }

    public function post($id){
        $post = Posts::find($id);
        if(isset($post['id'])){
            return $this->to($post['slug']);
        }
        return null;
    }
    
}
