<?php

require_once "../vendor/autoload.php";

class CurlService {
    public static function send($host, $data){
        // create a new cURL resource
        $ch = curl_init();

        // set URL and other appropriate options
        curl_setopt($ch, CURLOPT_URL, $host);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

        // grab URL and pass it to the browser
        $result = curl_exec($ch);

        // close cURL resource, and free up system resources
        curl_close($ch);

        return json_encode($result);
        // phpinfo();
    }
}
?>