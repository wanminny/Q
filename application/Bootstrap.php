<?php

/**
 * @name Bootstrap
 * @author zhanglirong
 * @desc 所有在Bootstrap类中, 以_init开头的方法, 都会被Yaf调用,
 * @see http://www.php.net/manual/en/class.yaf-bootstrap-abstract.php
 * 这些方法, 都接受一个参数:Yaf_Dispatcher $dispatcher
 * 调用的次序, 和申明的次序相同
 */

//use  Yaf\Bootstrap_Abstract;


class Bootstrap extends Yaf_Bootstrap_Abstract
{
    private $_config;

    public function _initConfig(Yaf_Dispatcher $dispatcher)
    {
        define('REQUEST_METHOD', strtoupper($dispatcher->getRequest()->getMethod()));
        $this->_config = Yaf_Application::app()->getConfig();
        Yaf_Registry::set('config', $this->_config);
    }

    public function _initQin(Yaf_Dispatcher $dispatcher)
    {
        ############################ Begin 配置 ############################
        $_config = ini_get('qin.config');
        $_environment = ini_get('qin.environment');
        defined('Q_APPLICATION_ENV') || define('Q_APPLICATION_ENV', $_environment);
        if (empty($_config)) {
            switch (Q_APPLICATION_ENV) {
                case Q_Core_Consts::Q_APPLICATION_ENV_LOCALING :
                    $_config = '/Data/bak/QF2.0/Framework/Config';
                    break;
                case Q_Core_Consts::Q_APPLICATION_ENV_TESTING :
                    $_config = '/Data/bak/QF2.0/Framework/Config';
                    break;
                case Q_Core_Consts::Q_APPLICATION_ENV_RELEASE :
                    $_config = '/Data/bak/QF2.0/Framework/Config';
                    break;
            }
        }
        defined('QIN_CONFIG') || define('QIN_CONFIG', $_config);
        $_qdebug = $dispatcher->getRequest()->getQuery('_qdebug');
        if (Q_APPLICATION_ENV != Q_Core_Consts::Q_APPLICATION_ENV_RELEASE || (!empty($_qdebug) && $_qdebug == 'display_errors')) {
            error_reporting(E_ALL);
            ini_set('display_startup_errors', 1);
            ini_set('display_errors', 1);
        }
        ############################ End 配置 ############################
    }

    public function _initNamespaces()
    {
        Yaf_Loader::getInstance()->registerLocalNameSpace(array('Models','QLib', 'QLibConfigs', 'QLibView'));
    }

    public function _initPlugin(Yaf_Dispatcher $dispatcher)
    {
        $dispatcher->registerPlugin(new QLib_Plugin_Routes());
    }

    public function _initRoute(Yaf_Dispatcher $dispatcher)
    {
        $config = new Yaf_Config_Ini(APPLICATION_PATH . '/configs/routes.ini');
        if (isset($config->routes)) {
            $dispatcher->getRouter()->addConfig($config->routes);
        }
    }

    public function _initLayout(Yaf_Dispatcher $dispatcher)
    {
        if (!$dispatcher->getRequest()->isXmlHttpRequest()) {
            $layoutPath = $this->_config->application->layout->path;
            $layout = new QLib_Layout($layoutPath);
            $dispatcher->setView($layout);
        }
    }
}
