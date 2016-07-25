<?php


namespace QLib;

use QLib\Concurrent\Yar;
use QLib\Concurrent\Http;

class Concurrent
{
    /**
     * @param $url
     * @return Yar\Client
     */
    static public function yarClient($url)
    {
        return new Yar\Client($url);
    }

    /**
     * @param $uri
     * @return Yar\Concurrent
     */
    static public function yarConcurrent($uri)
    {
        return new Yar\Concurrent($uri);
    }

    /**
     *
     * @return Http\CurlMulti
     */
    static public function curlMulti()
    {
        return new Http\CurlMulti();
    }
}