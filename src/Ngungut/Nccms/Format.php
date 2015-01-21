<?php namespace Ngungut\Nccms;

use Illuminate\Support\Str;
use Ngungut\Nccms\Model\Settings;
use Ngungut\Nccms\PluginManager;

class Format{
    public static function formats_date($date, $style=false, $hour=false)
    {
        if(!$style){
            if($hour){
                $style = 'd/m/Y H:i:s';
            }else{
                $style = Settings::getWebDateFormat();
                if(!$style) $style = 'd/m/Y';
            }
        }

        if (isset($date))
            return date($style, strtotime( $date ) );
        return '';
    }
    
    public static function prepare_date($date, $full = true)
    {
        $time = '';
        if($full){
            $exp = explode(' ', $date);
            $date = $exp[0];
            $time = ' ' . $exp[1];
        }
        if (isset($date) && $date != '') {
            $date = implode("-", array_reverse(explode("/", $date)));
            return $date . $time;
        }
        return null;
    }
    
    public static function count_time($date, $fullhour=false){
        if($date){
            $the = strtotime($date);
            $now = strtotime('now');
            $time = $now - $the;
            $sec = $time % 60;
            $min = $time / 60 % 60;
            $hour = $time / 3600 % 60;
            $day = $time / (24*3600) % 60;
            $week = $time / (7*24*3600) % 60;
            $month = $time / (30*24*3600) % 60;
            $year = $time / (12*30*24*3600) % 60;
            if($fullhour){
                if($year > 0){
                    return $year.' year ago';
                }else if($month > 0){
                    return $month.' month ago';
                }else if($day > 0){
                    return $day.' day ago';
                }else{
                    return (($hour > 0) ? $hour.' hour ':'') . (($min > 0) ? $min.' minutes':$sec.' second') . ' ago';
                }
            }else{
                if($year > 0){
                    return $year.' year ago';
                }else if($month > 0){
                    return $month.' month ago';
                }else if($day > 0){
                    return $day.' day ago';
                }else if($hour > 0){
                    return $hour.' hour ago';
                }else if($min > 0){
                    return $min.' minutes ago';
                }else{
                    return $sec.' second ago';
                }
            }
        }
        return null;
    }

    public static function toBytes($val) {
        $val = trim($val);
        $last = strtolower($val[strlen($val)-1]);
        switch($last) {
            // The 'G' modifier is available since PHP 5.1.0
            case 'g':
                $val *= 1024;
            case 'm':
                $val *= 1024;
            case 'k':
                $val *= 1024;
        }
    
        return $val;
    }

    public static function to_decimal($value, $decimal=0, $symbol=false)
    {
        if($value < 0)
        {
            return '( '.(($symbol) ? $symbol.' ':'').number_format(abs($value), 0, ',', '.').' )';
        }
        else
        {
            return number_format($value, $decimal, '.', '');
        }
    }
    
    public static function textToSlug($text){
        $slug = preg_replace('/[^a-zA-Z0-9_\']/', '-', $text);
        $output2 = $slug;
        do {
            $slug = $output2;
            $output2 = str_replace("--", "-", $slug);
        } while ($output2 != $slug);
        $output2 = trim($output2);
        $output2 = ltrim($output2, "-");
        $output2 = rtrim($output2, "-");
        $output2 = strtolower($output2);
        return $output2;
    }

    public static function slugToText($slug){
        $text = str_replace('-', ' ', $slug);
        $text= Str::title($text);
        return $text;
    }
    
    public static function postURL($id){
        $post = Posts::find($id);
        $y = date('Y', strtotime($post->updated_at));
        $m = date('m', strtotime($post->updated_at));
        $d = date('d', strtotime($post->updated_at));
        $time = date('His', strtotime($post->updated_at));
        
        return Config::get('app.url') . $y . '/' . $m . '/' . $d . '/' . $time . '/' . $post->title_slug;
    }
    
    public static function toRupiah($value, $symbol=FALSE, $decimal=0)
    {
        if($value < 0)
        {
            return '( '.(($symbol) ? $symbol.' ':'').number_format(abs($value), $decimal, ',', '.').' )';
        }
        else
        {
            if($value == 0) return '0';
            return (($symbol) ? $symbol.' ':'').number_format($value, $decimal, ',', '.');
        }
    }

    public static function renderPluginNavigation(){
        $pluginManager = PluginManager::instance();
        $li = '';
        foreach($pluginManager->getPlugins() as $plugin){
            foreach($plugin->registerNavigation() as $key => $nav){
                $class = isset($nav['subNav']) ? ' class="treeview"':'';
                $li .= '<li'.$class.'>';
                if($class){
                    $li .= '<a href="#">';
                    $li .= '<i class="fa '.$nav['icon'].'"></i>';
                    $li .= '<span>'.$nav['label'].'</span>';
                    $li .= '<i class="fa fa-angle-left pull-right"></i>';
                    $li .= '</a>';
                    $li .= '<ul class="treeview-menu">';
                    foreach($nav['subNav'] as $subnav){
                        $li .= '<li>';
                        $li .= '<a href="'.$subnav['url'].'"><i class="fa fa-angle-double-right"></i>';
                        $li .= $subnav['label'];
                        $li .= '</a>';
                        $li .= '</li>';
                    }
                    $li .= '</ul>';
                }else{
                    $li .= '<a href="'.$nav['url'].'">';
                    $li .= '<i class="fa '.$nav['icon'].'"></i>';
                    $li .= '<span>'.$nav['label'].'</span>';
                    $li .= '</a>';
                }
                $li .= '</li>';
            }
        }
        return $li;
    }

    public static function generateFilename($length=7){
        $hex = md5("02dHs3OQL=v7AEu" . uniqid("", true));
        $pack = pack('H*', $hex);
        $tmp =  base64_encode($pack);
        $uid = preg_replace("#(*UTF8)[^A-Za-z0-9]#", "", $tmp);
        $len = max(4, min(128, $length));
        while (strlen($uid) < $length){
            $uid .= static::generateFilename($length);
        };
        return substr($uid, 0, $length);
    }
}