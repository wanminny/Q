<?php
class IndexController extends QLib_Action
{
    public function indexAction()
    {

        echo "22222";
//        return false;
//        return false;
		$user = QINDemo_Models_Client::dao()->getOneByUid(1);

        $this->getView()->assign('user',$user);
//		print_R($user);die;
    }
    
    
    
}