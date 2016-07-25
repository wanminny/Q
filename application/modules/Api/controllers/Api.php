<?php
/**
 * Created by PhpStorm.
 * User: wanmin
 * Date: 16/7/25
 * Time: 下午1:44
 */

class ApiController extends Yaf_Controller_Abstract
{

    /**
     * 会员接口
     * @return boolean
     */
    public function userAction()
    {
        $service = new Yar_Server(new Models_Api_User());
        $service->handle();
        return false;
    }
    /**
     *    订单接口
     *    @return boolean
     */
    public function orderAction()
    {
        $service = new Yar_Server(new Models_Api_Order());
        $service->handle();
        return false;
    }

}

