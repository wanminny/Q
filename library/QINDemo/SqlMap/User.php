<?php
class QINDemo_SqlMap_User
{
	const getOneByMobile = "select * from test where mobile = :mobile";
	
	const getOneByUid = "select * from test where uid = :uid";
}