<?php
/**
 * Created by PhpStorm.
 * User: Zip
 * Date: 14/12/22
 * Time: 下午12:23
 */

namespace QLib\Concurrent\Http;

class Curl extends CurlAbstract
{

    /**
     * GET方式网络请求
     * @param $url
     * @param array $data
     * @param int $timeout
     * @return mixed
     */
    public static function get($url, array $data = array(), $timeout = 20)
    {
        $ch = curl_init(self::makeUrl($url, $data));
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }


    /**
     * post提交数据
     * @param $url
     * @param $data
     * @param int $timeout
     * @param array $header
     * @param array $cookie
     * @return mixed
     */
    public static function post($url, $data, $timeout = 20, array $header = array(), array $cookie = array())
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        if (!empty($header)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);// array('Content-Type:application/json;charset=UTF-8'));
        }

        if (!empty($cookie)) {
            $cookie_str = array();
            foreach ($cookie as $key => $val) {
                $cookie_str[] = urlencode($key) . '=' . urlencode($val);
            }
            curl_setopt($ch, CURLOPT_COOKIE, implode(';', $cookie_str));
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        if (!empty($data)) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
        $result = curl_exec($ch);
//        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return $result;
    }

}
