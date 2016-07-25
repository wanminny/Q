<?php


namespace QLib\Concurrent\Http;


class CurlAbstract
{
    public static function makeUrl($url, array $data)
    {
        $params = '';
        if (!empty($data)) {
            $params = http_build_query($data, '', '&');
        }
        if (strpos($url, '?') === false) {
            $url = $url . '?' . $params;
        } else {
            if (!empty($params)) {
                $url = $url . '&' . $params;
            }
        }
        return $url;
    }
} 