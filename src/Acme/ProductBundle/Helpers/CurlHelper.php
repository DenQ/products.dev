<?php
namespace Acme\ProductBundle\Helpers;

class CurlHelper {

    static $ch = null;

    static public function Send($url, $method, $data = array())
    {
        $url = 'http://products.dev/app_dev.php/' . $url;
        self::$ch = curl_init();
        curl_setopt(self::$ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt(self::$ch, CURLOPT_URL, $url);
        curl_setopt(self::$ch, CURLOPT_FOLLOWLOCATION, false);
        curl_setopt(self::$ch, CURLOPT_RETURNTRANSFER, TRUE);
        return curl_exec(self::$ch);
    }

    static public function GetHttpCode()
    {
        return curl_getinfo(self::$ch, CURLINFO_HTTP_CODE);
    }

}