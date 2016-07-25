<?php
/**
 * Created by PhpStorm.
 * User: wanmin
 * Date: 16/7/25
 * Time: 下午1:59
 */


/**
 * 公共的客户端调用逻辑包括验证以及单接口；多接口等；基础类；
 *
 *
*/
class Models_Client_ApiClient
{


    private static $signs = array(
        'sign1',
        'sign2'
        // ....
    );

    private $callBack;
    private $callNum=0;

    /**
     * 取得签名
     * @param  $params 接口调用时的参数
     */
    protected function getSign($params)
    {
        ksort($params);
        $signStr = '';
        foreach($params as $key => $val)
        {
            if(empty($val)) continue;
            $signStr .= $key.'='.$val.'&';
        }
        $signStr = rtrim($signStr,'&');
        return md5($signStr.self::$signs[mt_rand(0,count(self::$signs)-1)]);
    }
    /**
     * 调用服务端接口
     * @param  $server        Api server
     * @param  $api            接口
     * @param  $params        参数
     * @param  $openSign    开启签名
     * @param  $callBack    回调
     */
    public function call($server,$api,$params,$openSign=false,$callBack=null)
    {
        if($openSign){
            $params['sign'] = $this->getSign($params);
        }

        if($callBack === null){
            $client = new \Yar_Client("http://qin.com/api/api/User");
            var_dump($client,$api);
            return call_user_func(array($client,$api), $params);
        }
        $this->callNum ++;
        $this->callBack = $callBack;
        return \Yar_Concurrent_Client::call($server,$api,$params,array($this, 'ApiClientCallBack'));
    }
    /**
     * 执行并发调用
     */
    public function loop()
    {
        return \Yar_Concurrent_Client::loop();
    }
    /**
     * 并发调用回调
     * @param  $retval
     * @param  $callinfo
     */
    public function ApiClientCallBack($retval,$callinfo)
    {
        if($callinfo === null){
            return $this->callBack($retval,$callinfo);
        }
        static $data = array();
        $data[$callinfo['method']] = $retval;
        if(count($data) == $this->callNum){
            $fn = $this->callBack;
            return $fn($data,$callinfo);
        }
    }
}
