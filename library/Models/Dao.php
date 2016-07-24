<?php



abstract class Models_Dao
{
    /**
     * 数据对象
     *
     * @var Q_Dao_SqlMap_MapQuery
     */
    protected $dao = array();
    /**
     * 过期时间
     *
     * @var Integer
     */
    protected $expire = 300;

    /**
     * 路由
     *
     * @var String
     */
    protected $router = NULL;

    /**
     * 得到数据存储对象
     *
     * @param false|string $db
     * @param String $router
     * @return Q_Db_Mysql_SqlMap_MapQuery
     */
    protected function dao($router = NULL)
    {
        $router_str = empty($router) ? $this->router : $router;
        $sqlMapPath = realpath(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'SqlMap';
        return Q_Db::mysql($router_str, $sqlMapPath);
    }

    /**
     * 组织动态参数数据
     *
     * @param array $parameter
     * @param string $operator
     * @return String
     */
    static function makeParameter(array $parameter, $operator = ' and ')
    {
        if (empty($parameter)) {
            return '';
        }
        $pieces = array();
        foreach ($parameter as $key => $val)
        {
            $pieces[] = $key . '=:' . $key;
        }
        $replaceStr = implode($operator, $pieces);
        return $replaceStr;
    }

}