<?php

/**
 * @name ErrorController
 * @desc 错误控制器, 在发生未捕获的异常时刻被调用
 * @see http://www.php.net/manual/en/yaf-dispatcher.catchexception.php
 * @author lirong.zhang
 */
class ErrorController extends QLib_Actions_Default
{

    //从2.1开始, errorAction支持直接通过参数获取异常
    public function errorAction($exception)
    {
        if (defined('Q_APPLICATION_ENV') && Q_APPLICATION_ENV == 'release') {
            $meg = date('Y-m-d H:i:s') . "\n";
            $meg .= 'IP:' . Q_Utils_Request::getClientIp() . "\n";
            @$meg .= 'HTTP_REFERER: ' . isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '' . "\n";
            $meg .= var_export($exception->getMessage(), true) . "\n\n";
            error_log($meg, 3, '/Data/logs/site/hcllAdmin.' . date('Ymd') . '.log');
        } else {
            $this->getView()->assign("exception", $exception);
        }
    }

    public function error($exception)
    {

    }

    public function indexAction(){
        $this->getView()->render('error/error.phtml');
    }
}
