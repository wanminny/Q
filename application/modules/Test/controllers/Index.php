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

        echo "3333";
//        return false;
        $user = Models_Facade_Open_Test::dao()->getOneByUid(1);
//        Models_Facade_Open_Test

        $this->getView()->assign('user',$user);
//        return false;
//		print_R($user);die;
    }



}