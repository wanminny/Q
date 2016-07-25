<?php
/**
 * Created by PhpStorm.
 * User: wanmin
 * Date: 16/7/24
 * Time: 下午6:49
 */

class ConsoleController extends QLib_Action
{
    public function indexAction()
    {
        echo __METHOD__;
        return false;
//		print_R($user);die;
    }



}