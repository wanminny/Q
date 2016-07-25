<?php

namespace QLib\Concurrent\Yar;


class Concurrent
{
    private $uri;

    public function __construct($uri)
    {
        $this->uri = $uri;
    }

    /**
     * 注册一个并行的服务调用
     * @param $uri
     * @param $method
     * @param $parameters
     * @param string $callback
     */
    public function call($uri, $method, $parameters, $callback = '')
    {
        \Yar_Concurrent_Client::call($uri, $method, $parameters, $callback);
    }

    /**
     * 链式调用
     * @param $method
     * @param $parameters
     * @param string $callback
     * @return $this
     */
    public function calls($method, $parameters, $callback = '')
    {
        $this->call($this->uri, $method, $parameters, $callback);
        return $this;
    }

    /**
     * 发送所有注册的并行调用
     * @param string $callback
     * @param callable $errorCallback
     */
    public function loop($callback = '', $errorCallback = '')
    {
        \Yar_Concurrent_Client::loop($callback, $errorCallback);
    }

    /**
     * 缓存tag
     * @param $tagName
     * @return $this
     */
    public function tag($tagName)
    {
        $this->_cacheTagName = $tagName;
        return $this;
    }

    /**
     * 缓存key
     * @param string $key
     * @param null $prefix
     * @return $this
     */
    public function key($key)
    {
        $this->_cacheKey = (string)$key;
        return $this;
    }

    /**
     * 缓存时间
     * @param $expire
     * @return $this
     */
    public function expire($expire)
    {
        $this->_cacheExpire = (int)$expire;
        return $this;
    }


//    use Hood\Concurrent;
//$CurlMulti = Concurrent::curlMulti();
//$CurlMulti->get('http://www.baidu.com',function ($curl_data,$curl_info) {
//    print_r($curl_info);
//}, 1)->post('http://www.sogou.com',function ($curl_data,$curl_info) {
//    print_r($curl_info);
//}, 2)->finish();
//
//
//$CurlMulti = Concurrent::curlMulti();
//$CurlMulti->callRest('http://www.qin.com/index/demo', 'get', function ($curl_data,$curl_info) {
//    print_r($curl_data);
//}, array('a' => 1))->finish();
} 