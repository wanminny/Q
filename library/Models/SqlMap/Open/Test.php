<?php
/**
 * Created by PhpStorm.
 * User: wanmin
 * Date: 16/7/24
 * Time: 下午4:21
 */

class Models_SqlMap_Open_Test
{
    const getOneByMobile = "select * from test where mobile = :mobile";

    const getOneByUid = "select * from test where uid = :uid";
}

