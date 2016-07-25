<?php
/**
 * Created by PhpStorm.
 * User: wanmin
 * Date: 16/7/24
 * Time: 下午4:18
 */

class Models_Facade_Open_Test {

    /**
     *
     * @var QINDemo_Models_Dao
     */
    private static $dao;

    private static $self;

    /**
     * @return Models_Service_Open_Test
     */
    public static function dao()
    {
        if (empty(self::$dao)) {
            self::$dao = new Models_Service_Open_Test();
        }
        return self::$dao;
    }



}
