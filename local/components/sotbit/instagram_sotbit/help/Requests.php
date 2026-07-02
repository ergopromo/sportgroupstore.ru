<?php

class CurlRequests
{
    private static $baseUrl = 'https://graph.instagram.com';
    private static $apiUrl = 'https://api.instagram.com';

    public static function sendGetCurlRequest($url, $params = []) {
        $ch = curl_init();

        $paramsStr = "";
        if (isset($params)) {
            $i = 0;
            foreach ($params as $key => $param) {
                if ($i == 0)
                    $paramsStr .= "?".$key.'='.$param;
                else
                    $paramsStr .= "&".$key.'='.$param;
                $i++;
            }
        }

        curl_setopt($ch, CURLOPT_URL, self::$baseUrl . $url . $paramsStr);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($ch);
        curl_close($ch);

        return json_decode($result);
    }

    public static function sendPostCurlRequest($url, $params = []) {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, self::$apiUrl . $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);

        $result = curl_exec($ch);
        curl_close($ch);

        return json_decode($result);
    }
}
