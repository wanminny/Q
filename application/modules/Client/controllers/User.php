<?php
/**
 * Created by PhpStorm.
 * User: wanmin
 * Date: 16/7/25
 * Time: 下午2:01
 */

// 使用YAR client调用 YAR SERVER ;


///一般作为前端直接调用或者是作为内部客户端调用SERVER；又或者是作为另外一个服务器调用拼装；
///此处为了简单 ；将他们放在了一个服务器使用测试；

class UserController extends Yaf_Controller_Abstract
{
    /**
     * 最普通的调用不需要携带验证信息的调用
     *
     */
    public function getInfoAction()
    {
        header('Content-type:text/html;charset=utf-8');
        $client = new Yar_Client("http://qin.com/Api/Api/User");
        $result = $client->getUserInfo(10);
        var_dump($result);
        return false;

    }

    /**
     * 需要携带验证信息的调用
     * 单接口调用
     *
    */
    public function getUserInfoAction()
    {
        $apiClinet = new Models_Client_ApiClient();

        $userInfo = $apiClinet->call("http://qin.com/Api/Api/User", 'getUserInfo', array(10));
        var_dump($userInfo );
        return false;
    }

    /**
     * 需要携带验证信息的调用
     * 多接口调用
     *
     */
    public function getUserMultiAction()
    {
        $apiClinet = new Models_Client_ApiClient();
        ///$callinfo 是参数信息 【最后一个CALL的函数信息】
        function callback($data,$callinfo){
            var_dump($callinfo,$data);
        }
        $apiClinet->call("http://qin.com/Api/Api/User", 'getUserInfo', array(10),false,'callback');
        $apiClinet->call("http://qin.com/Api/Api/Order", 'getOrderInfo', array(10),true,'callback');
        $apiClinet->loop();
        return false;
    }


}

