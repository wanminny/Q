<?php
class IndexController extends QLib_Action
{
    public function indexAction()
    {
		$user = Models_Facade_Open_Test::dao()->getOneByUid(1);
        $this->getView()->assign('user',$user);
//		print_R($user);die;
    }
    
    
    
}