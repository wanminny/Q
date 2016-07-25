<?php

namespace QLib\Concurrent\Yar;


class Client
{
    /**
     * @var array
     */
    private $_instances = array();

    /**
     * @var \Yar_Client
     */
    private $client;

    /**
     * Set timeout to 3s
     * @var int
     */
    private $_timeout = 3000;

    /**
     * @param $uri
     */
    public function __construct($uri)
    {
        $yarKey = md5($uri);
        if (!isset($this->_instances[$yarKey])) {
            $this->_instances[$yarKey] = new \Yar_Client($uri);
        }
        $this->client = $this->_instances[$yarKey];
    }

    /**
     * 设置yar参数
     * @param $name
     * @param $value
     */
    public function setOpt($name, $value)
    {
        $this->client->setOpt($name, $value);
        return $this;
    }

    /**
     * 数据包类型
     * @param string $packagerType
     */
    public function setPackager($packagerType = YAR_PACKAGER_PHP)
    {
        $this->client->setOpt(YAR_OPT_PACKAGER, $packagerType);
        return $this;
    }

    /**
     * 连接超时(毫秒为单位)
     * @param $timeout
     */
    public function setConnectTimeout($timeout = 1000)
    {
        $this->client->setOpt(YAR_OPT_CONNECT_TIMEOUT, $timeout);
        return $this;
    }

    /**
     * Set timeout to 3s
     * 处理超时(毫秒为单位)
     * @param $timeout
     * @return $this
     */
    public function setTimeout($timeout = 3000)
    {
        $this->client->setOpt(YAR_OPT_TIMEOUT, $timeout);
        return $this;
    }

    /**
     * @param $name
     * @param array $arguments
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return $this->client->__call($method, $parameters);
    }
} 