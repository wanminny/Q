<?php
/**
 * Created by PhpStorm.
 * User: wanmin
 * Date: 16/7/24
 * Time: 上午9:09
 */

class IndexController extends QLib_Action
{


    public function infoAction()
    {
        phpinfo();

    }


    public function indexAction()
    {

        var_dump((bool)ini_get("apc.enabled"));
        echo 11;
        echo __METHOD__;
//        return false;
        $user = Models_Facade_Open_Test::dao()->getOneByUid(1);
//var_dump($user);
        $this->getView()->assign('user',$user);
//        return false;
//		print_R($user);die;
    }



}