<?php
/**
 * Created by PhpStorm.
 * User: wanmin
 * Date: 16/7/27
 * Time: 上午9:22
 */
///swoole http_server


class HttpServer
{
    public static $instance;
    public $http;
    private $application;
    public function __construct() {
        $http = new swoole_http_server("0.0.0.0", 9501);
        $http->set(
            array(
                'worker_num' => 16,
                'daemonize' => 0,
                'max_request' => 10000,
                'dispatch_mode' => 1
            )
        );

        define('APPLICATION_PATH', dirname(__DIR__));
###########################################################################################
        defined('Q_APPLICATION_ENV') || define('Q_APPLICATION_ENV', (ini_get('yaf.environ') ? ini_get('yaf.environ') : 'localing'));
###########################################################################################
//set_include_path(implode(PATH_SEPARATOR, array(get_include_path(),'/Data/bak/common')));
        set_include_path(implode(PATH_SEPARATOR, array(get_include_path(),'/Data/bak/QF2.0/Framework')));
        include("/Data/bak/QF2.0/Framework/Q/Autoloader.php");  //以及配置了yaf.library;

        if (!empty($_GET['_qdebug']) && $_GET['_qdebug'] == 'xhprof') {
            $_beginTime = microtime(true);
            $shprof = new Q_Debug_Xhprof_Stat();
//    $shprof->setUrl('http://xhprof.debug.yohobuy.com')->start();
            $shprof->setUrl('http://xhprof.com')->start();//your domain; notice!!
            echo (microtime(true) - $_beginTime) . ' Start Xhprof Time.<br />';
        }

        $this->application = new Yaf_Application(APPLICATION_PATH . "/configs/application.ini");
        $this->application->bootstrap();

        if (!empty($_GET['_qdebug']) && $_GET['_qdebug'] == 'xhprof') {
            echo '<br />' . (microtime(true) - $_beginTime) . ' End Run Time.<br />';
            $shprof->end();
            echo '<br />' . (microtime(true) - $_beginTime) . ' End Xhprof Time.<br />';
        }



//        define('APPLICATION_PATH', dirname(dirname(__DIR__)). "/application");
//        $this->application = new Yaf_Application(dirname(APPLICATION_PATH). "/conf/application.ini");
//        $this->application->bootstrap();

        $http->on('Request',array($this , 'onRequest'));
        $http->start();
    }
    public function onRequest($request,$response) {
        $response->status('200');
        $ser=$request->server;
        $hea= $request->header;
        $hea['host']=str_replace(':9501','',$hea['host']);//如果端口号是80，就不用要此句代码
        ob_start();
        try {
            $yaf_request = new Yaf_Request_Http($ser['request_uri']);
            $yaf_request->setBaseUri($hea['host']);
            $this->application->getDispatcher()->dispatch($yaf_request);
        } catch ( Yaf_Exception $e ) {
            //var_dump( $e );
        }
        $result = ob_get_contents();
        ob_end_clean();
        $response->end($result);
    }

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new HttpServer;
        }
        return self::$instance;
    }
}
HttpServer::getInstance();
