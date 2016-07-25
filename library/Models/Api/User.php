<?php
/**
 * Created by PhpStorm.
 * User: wanmin
 * Date: 16/7/25
 * Time: 下午1:46
 */

class Models_Api_User extends Models_Api_ApiServer
{

     /**
      * your xx
     */
    public function info()
    {
        echo __METHOD__;
    }

    /**
     * 获取会员信息
     * @param int $userId    用户ID
     * return Array [会员信息]
     */
    public function getUserInfo($userId)
    {

        // ... 业务处理
        $data = array('userName'=>'zhangsan','nickName'=>'张三','regTime'=>'2014-12-01 10:10:10');

        return $this->response(1,$data);
    }



}