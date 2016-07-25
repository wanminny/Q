<?php


//use Yaf\Application;

header("server: HCLL-SERVER");
define('APPLICATION_PATH', dirname(__DIR__));
###########################################################################################
defined('Q_APPLICATION_ENV') || define('Q_APPLICATION_ENV', (ini_get('yaf.environ') ? ini_get('yaf.environ') : 'localing'));
###########################################################################################
//set_include_path(implode(PATH_SEPARATOR, array(get_include_path(), ini_get('qin.path'))));
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

$application = new Yaf_Application(APPLICATION_PATH . "/configs/application.ini");
$application->bootstrap()->run();

if (!empty($_GET['_qdebug']) && $_GET['_qdebug'] == 'xhprof') {
    echo '<br />' . (microtime(true) - $_beginTime) . ' End Run Time.<br />';
    $shprof->end();
    echo '<br />' . (microtime(true) - $_beginTime) . ' End Xhprof Time.<br />';
}
