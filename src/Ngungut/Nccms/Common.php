<?php namespace Ngungut\Nccms;

class Common{
    public static function debug($x, $exit=0){
        echo $res = "<pre>";
        if(is_array($x) || is_object($x)){
            echo print_r($x);
        }else{
            echo var_dump($x);
        }
        echo "</pre><hr />";
        if($exit==1){ die(); }
    }
    
    public static function Encrypt($data=false, $iv=false) {
        if(!$data) return FALSE;
        $key = '1725795437178523';
        $padding = 16 - (strlen($data) % 16);
        $data .= str_repeat(chr($padding), $padding);
        return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $data, MCRYPT_MODE_ECB));
    }
    
    public static function Decrypt($data, $iv=false) {
        $key = '1725795437178523';
        $data = base64_decode($data);
        $data = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $data, MCRYPT_MODE_ECB);
        $padding = ord($data[strlen($data) - 1]);
        return substr($data, 0, -$padding);
    }
    
}
