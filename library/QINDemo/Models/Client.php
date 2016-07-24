<?php

/**
 * 用户信息
 * @author i@zhanglirong.cn
 * @date 2016.07.23
 * @tine 01:48 pm
 */
class QINDemo_Models_Client {

    /**
     *
     * @var QINDemo_Models_Dao
     */
    private static $dao;
    
    private static $self;

    /**
     * @return QINDemo_Models_Dao
     */
    public static function dao() 
    {
    	if (empty(self::$dao)) {
        	self::$dao = new QINDemo_Models_Dao();
        }
        return self::$dao;
    }
    
    

}
