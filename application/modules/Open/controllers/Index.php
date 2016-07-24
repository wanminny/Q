<?php
/**
 * Created by PhpStorm.
 * User: wanmin
 * Date: 16/7/24
 * Time: 上午9:09
 */

class IndexController extends QLib_Action
{
    public function indexAction()
    {
        echo 11;
        echo __METHOD__;
//        return false;
        $user = QINDemo_Models_Client::dao()->getOneByUid(1);

        $this->getView()->assign('user',$user);
//        return false;
//		print_R($user);die;
    }



}