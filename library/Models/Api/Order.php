<?php
/**
 * Created by PhpStorm.
 * User: wanmin
 * Date: 16/7/25
 * Time: 下午1:47
 */

class Models_Api_Order extends  Models_Api_ApiServer
{

    /**
     * your 注释；
     * @param
     * @param
     * @return
     *
    */
    public function orderinfo()
    {
        echo __METHOD__;
    }

    /**
     * 获取会员信息
     * @param int $orderId     订单ID
     * @param str $sign 签名
     * return Array [订单信息]
     *
     * 内网调用；
     */
    public function getOrderInfo($orderId,$sign)
    {
        //验证签名
        if(!$this->checkSign(func_get_args(),$sign)){
            return $this->response(0,array(
                'code'=>'SIGN_ERROR',
                'errMsg'=>'签名错误'
            ));
        }
        // ... 业务处理

        $data = array('orderId'=>$orderId,'orderStatus'=>'success');
        return $this->response(1, $data);
    }

}