<?php

/**
 * Created by PhpStorm.
 * User: zhanglirong
 * Date: 15-1-15
 * Time: 16:13
 */



class QLib_Plugin_Routes extends Yaf_Plugin_Abstract
{
    /**
     *
     *
     * 在路由之前触发，这个是7个事件中, 最早的一个. 但是一些全局自定的工作, 还是应该放在Bootstrap中去完成
     * @param Yaf_Request_Abstract $request
     * @param Yaf_Response_Abstract $response
     * @return bool|void
     */
    public function routerStartup(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response)
    {
    	$_httpResult = explode('.', $request->getServer('HTTP_HOST'));
    	$level = 'm';
    	
    	if (count($_httpResult) == 3) {
    		list ($level, $domainName, $suffix) = $_httpResult;
    	} else if (count($_httpResult) == 4) {
    		list ($sonLevel, $level, $domainName, $suffix) = $_httpResult;
    		$brand = QINProduct_Models_Brand_Client::getBrandInfoByDomain($sonLevel);
    		if (!empty($brand)) {
    			$level = "Brand";
    		} else {
    			$level = $sonLevel;
    		}
    	}
    	$_config = Yaf_Registry::get('config');
    	$_modulesList = array();
    	if (!empty($_config['application']['modules'])) {
    		$_modules = $_config['application']['modules'];
    		$_modulesList = explode(',', $_modules);
    	}
    	if ($level != 'm' && in_array(ucfirst($level), $_modulesList, true)) {
    		$request->module = ucfirst($level);
    		$dispatcher = Yaf_Dispatcher::getInstance();
    		$app = $dispatcher->getApplication();
    		$file = $app->getAppDirectory() . "/modules/".ucfirst($level)."/__init.php";
    		if (file_exists($file)) {
    			Yaf_Loader::import($file);
    		}
    	}
    }

} 