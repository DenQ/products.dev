<?php
namespace Acme\ProductBundle\Helpers;

class CurlHelper {

    static public function Send($url, $method, $data = array())
    {
        $url = 'http://products.dev/app_dev.php/' . $url;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        return curl_exec($ch);
    }

}