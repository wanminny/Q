<?php

/**
 * 用户信息
 * @author i@zhanglirong.cn
 * @date 2016.07.23
 * @tine 01:48 pm
 */

class QINDemo_Models_Dao extends QINDemo_Dao {

    public function __construct() {
        $this->router = 'test.yh_ch';
    }

    public $_tag = 'marry_member';

    /**
     * 根据手机号获取一条记录(无缓存，登录用)
     * @param $mobile
     * @return array
     */
    public function getOneByMobileNoCache($mobile){
    	if(empty($mobile)){
    		return array();
    	}
    	$params = array(
    		'mobile' => $mobile
    	);

    	return $this->dao()->cache(false)->fetchRow(QINDemo_SqlMap_User::getOneByMobile, $params);
    }
    
    /**
     * 根据uid获取一条记录
     * @param $uid
     * @return array
     */
    public function getOneByUid($uid){
    	if(empty($uid)){
    		return array();
    	}
    	$params = array(
    		'uid' => $uid
    	);
        echo 56;
    	return $this->dao()->cache(false)->tag($this->_tag)->key("uid = $uid")->expire(3600*12)->fetchRow(QINDemo_SqlMap_User::getOneByUid, $params);
    }
    

   
    
    
}





