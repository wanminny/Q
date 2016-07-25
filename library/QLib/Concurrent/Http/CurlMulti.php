<?php

namespace QLib\Concurrent\Http;

class CurlMulti extends CurlAbstract
{

    private $_curls = array();

    private $_handle = NULL;

    private $wait_for_connect = false;

    private $headerData = array();


    public function __construct()
    {
        $this->_handle = curl_multi_init();
    }

    public function __destruct()
    {
        foreach ($this->_curls as $handle_id => $data) {
            curl_multi_remove_handle($this->_handle, $data['handle']);
            curl_close($data['handle']);
        }
        curl_multi_close($this->_handle);
    }

    /**
     * 设置是否等待
     * @param $wait_for_connect
     * @return $this
     */
    public function wait($wait_for_connect)
    {
        $this->wait_for_connect = $wait_for_connect;
        return $this;
    }

    /**
     * 设置header
     * @param array $headerData
     * @return $this
     */
    public function header(array $headerData)
    {
        $this->headerData = $headerData;
        return $this;
    }

    /**
     * 调用
     * @param $url
     * @param $callback
     * @param $data
     * @return $this
     * @throws Exception
     */
    public function get($url, $callback, array $data = array())
    {
        $ch = curl_init(self::makeUrl($url, $data));
        $this->addHandle($ch, $callback, $data, $this->wait_for_connect);
        return $this;
    }

    /**
     * 调用
     * @param $url
     * @param $callback
     * @param $data
     * @return $this
     * @throws Exception
     */
    public function post($url, $callback, $data)
    {
        $this->callRest($url, 'POST', $callback, $data);
        return $this;
    }


    /**
     * rest 请求方法
     * @param $url
     * @param $method
     * @param $callback
     * @param null $data
     * @return $this
     * @throws Exception
     */
    public function callRest($url, $method, $callback, $data = NULL)
    {
        switch (strtoupper($method)) {
            case 'POST':
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_POST, TRUE);
                $this->headerData = array_merge($this->headerData, array("X-HTTP-Method-Override: POST"));
                if ($data != null) {
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                }
                break;
            case 'DELETE':
                $ch = curl_init(self::makeUrl($url, $data));
                $this->headerData = array_merge($this->headerData, array("X-HTTP-Method-Override: DELETE"));
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
                break;
            case 'PUT':
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
                $this->headerData = array_merge($this->headerData, array("X-HTTP-Method-Override: PUT"));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                if ($data != null) {
                    $params = http_build_query($data, '', '&');
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
                    curl_setopt($ch, CURLOPT_INFILESIZE, strlen($params));
                }
                break;
            case 'GET':
                $ch = curl_init(self::makeUrl($url, $data));
                $this->headerData = array_merge($this->headerData, array("X-HTTP-Method-Override: GET"));
                break;
        }
        $this->addHandle($ch, $callback, $data, $this->wait_for_connect);
        return $this;
    }

    /**
     * 添加一个handle
     * @param $curl_handle
     * @param $callback
     * @param $data
     * @param bool $wait_for_connect #是否等待
     * @return bool
     * @throws Exception
     */
    private function addHandle($curl_handle, $callback, $data, $wait_for_connect = false)
    {
        if (get_resource_type($curl_handle) !== 'curl' || !is_callable($callback)) {
            throw new \Exception("Invalid curl handle or callback");
        }
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, TRUE);
        if (!empty($this->headerData)) {
            curl_setopt($curl_handle, CURLOPT_HTTPHEADER, $this->headerData);
        }
        $this->_curls[(int)$curl_handle] = array(
            'handle' => $curl_handle,
            'callback' => $callback,
            'callback_data' => $data,
        );
        curl_multi_add_handle($this->_handle, $curl_handle);
        if ($wait_for_connect) {
            $this->poll();
        }
        return TRUE;
    }

    /**
     * 移除会话中的hendle
     * @param $curl_handle
     * @return bool
     */
    public function removeHandle($curl_handle)
    {
        if (!isset($this->_curls[(int)$curl_handle])) {
            return FALSE;
        }
        curl_multi_remove_handle($this->_handle, $curl_handle);
        unset($this->_curls[(int)$curl_handle]);
        return TRUE;
    }

    /**
     * 等待所有会话
     * @return bool
     */
    public function poll()
    {
        $still_running = 0;
        do {
            $result = curl_multi_exec($this->_handle, $still_running);
            if ($result == CURLM_OK) {
                do {
                    $messages_in_queue = 0;
                    $info = curl_multi_info_read($this->_handle, $messages_in_queue);
                    if ($info && isset($info['handle']) && isset($this->_curls[(int)$info['handle']])) {
                        $callback_info = $this->_curls[(int)$info['handle']];
                        $curl_data = curl_multi_getcontent($info['handle']);
                        $curl_info = curl_getinfo($info['handle']);
                        call_user_func($callback_info['callback'], $curl_data, $curl_info);
                        $this->removeHandle($info['handle']);
                        curl_close($info['handle']);
                    }
                } while ($messages_in_queue > 0);
            }
        } while ($result == CURLM_CALL_MULTI_PERFORM && $still_running > 0);
        return (boolean)$this->_curls;
    }

    /**
     * 设置堵塞中的会话超时时间
     * @param float $timeout
     * @return bool
     */
    public function select($timeout = 1.0)
    {
        $result = $this->poll();
        if ($result) {
            curl_multi_select($this->_handle, $timeout);
            $result = $this->poll();
        }
        return $result;
    }

    /**
     * 刷新所有会话超时时间
     * @return bool
     */
    public function finish()
    {
        while ($this->select() === TRUE) {
        }
        return TRUE;
    }
}