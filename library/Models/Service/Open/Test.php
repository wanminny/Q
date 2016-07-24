<?php
/**
 * Created by PhpStorm.
 * User: wanmin
 * Date: 16/7/24
 * Time: 下午4:20
 */

class Models_Service_Open_Test extends Models_Dao
{

    public function __construct() {
        $this->router = 'test.yh_ch';
    }

    public $_tag = 'marry_member';

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
        return $this->dao()->cache(false)->tag($this->_tag)->key("uid = $uid")->expire(3600*12)->fetchRow(Models_SqlMap_Open_Test::getOneByUid, $params);
    }



}
