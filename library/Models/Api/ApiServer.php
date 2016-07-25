<?php
/**
 * Created by PhpStorm.
 * User: wanmin
 * Date: 16/7/25
 * Time: 下午1:54
 */

/**
 * 公共服务器需要验证权限等；  基类
*/

class Models_Api_ApiServer
{
    private static $signs = array(
        'sign1',
        'sign2'
        // ....
    );
    /**
     * 验证签名
     * @param  $params 接口调用时的参数
     * @param  $sign   签名
     */
    protected function checkSign($params,$sign)
    {
        if(empty($sign)){
            return false;
        }
        ksort($params);
        $signStr = '';
        foreach($params as $key => $val)
        {
            if(empty($val) || $val == $sign) continue;
            $signStr .= $key.'='.$val.'&';
        }
        $signStr = rtrim($signStr,'&');
        foreach (self::$signs as $v){
            if(md5($signStr.$v) === $sign){
                return true;
            }
        }
        return false;
    }
    /**
     * 返回接口处理结果
     * @param  $status
     * @param  $data
     * @param  $other
     * return  Array [格式化好了的结果]
     */
    protected function response($status,$data,$other=array())
    {
        $response = array ();
        $response ['status'] = ( bool ) $status;
        $response ['data'] = $data;
        if (is_array ( $other ) && ! empty ( $other )) {
            foreach ( $other as $k => $v ) {
                // 附加信息不能使用的键名
                if (! in_array ( $k, array (
                    'status',
                    'data'
                ) )) {
                    $response [$k] = $v;
                }
            }
        }
        return $response;
    }
}
