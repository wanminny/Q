<?php



//namespace QLib;

class QLib_Action extends Q_Action
{
    private $_appConfig = array();
    private $key = '350c127d1c1d10dbc0bfcb9e254ce2b9';
    private $_sessionNamespace = array();

    public function init()
    {
        $this->_headTitle('婚车来啦');
        //$this->_appConfig = $this->_config();
        //$this->pid = $this->_getpid();
        $isXmlHttpRequest = $this->getRequest()->isXmlHttpRequest();
        if ($isXmlHttpRequest == false) {
        	$this->_setLayout();
        }
        //$this->_assign('pid', $this->pid);
    }

    /**
     * @param $template
     * @return QLib_Paging
     */
    public function _paging($template)
    {
        $paging = new QLib_Paging($template);
        return $paging;
    }

    public function _assign($name, $value)
    {
        return $this->getView()->assign($name, $value);
    }

    /**
     * 获取初始化注册的config
     * @param string $name
     * @return mixed
     */
    public function _config($name = 'config')
    {
        return Yaf_Registry::get($name);
    }


    /**
     * 获取JS URL
     *
     * @param String $jsName
     * @return String
     */
    public function _js($jsName, $local = false)
    {
        if (isset(QLibConfigs_Static::$_js[$jsName])) {
            $js = QLibConfigs_Static::$staticUrl;
            if ($local == false) {
                $js .= QLibConfigs_Static::$_js[$jsName];
            } else {
                $js = QLibConfigs_Static::$_js[$jsName];
            }
            return $js;
        }
        return '';
    }

    /**
     * 获取Css URL
     *
     * @param String $cssName
     * @return String
     */
    public function _css($cssName, $local = false)
    {
        if (isset(QLibConfigs_Static::$_css[$cssName])) {
            $css = QLibConfigs_Static::$staticUrl;
            if ($local == false) {
                $css .= QLibConfigs_Static::$_css[$cssName];
            } else {
                $css = QLibConfigs_Static::$_css[$cssName];
            }
            return $css;
        }
        return '';
    }

    /**
     * TODO
     * @param string $layout
     * @param string $layoutPath
     */
    public function _setLayout($layout = 'default', $layoutPath = '')
    {
        if (!empty($layoutPath)) {
            $this->_config = Yaf_Application::app()->getConfig();
            $this->setLayoutPath();
        }
        $this->getView()->setLayout($layout);
    }

    /**
     * 获取参数
     * @param null $name
     * @param null $default
     * @return mixed
     */
    protected function _getEnv($name = null, $default = null)
    {
        return $this->getRequest()->getEnv($name, $default);
    }

    /**
     * 封装一下获取param参数
     * @param String $key
     * @param mixed $default
     * @return mixed
     */
    protected function _getParam($key, $default = null)
    {
        return $this->getRequest()->getParam($key, $default);
    }

    /**
     * 获取所有参数
     * @return array
     */
    protected function _getParams()
    {
        return $this->_request->getParams();
    }

    /**
     * 获取所有参数
     * @return mixed
     */
    protected function _getRequests()
    {
        return $this->_request->getRequest();
    }

    /**
     * 封装一下获取get参数
     * @param String $key
     * @param mixed $default
     * @return mixed
     */
    protected function _get($key, $default = null)
    {
        return $this->getRequest()->getQuery($key, $default);
    }

    /**
     * 封装一下获取post参数
     * @param String $key
     * @param mixed $default
     * @return mixed
     */
    protected function _post($key, $default = null)
    {
        return $this->getRequest()->getPost($key, $default);
    }

    /**
     * 封装一下获取post参数
     * @param String $key
     * @param mixed $default
     * @return mixed
     */
    protected function _typePost($key, $settype = null, $default = null)
    {
        $result = $this->getRequest()->getPost($key, $default);
        switch ($settype) {
            case 'bool':
                $result = (bool)$result;
                break;
            case 'int':
                $result = (int)$result;
                break;
            case 'string':
                $result = (string)$result;
                break;
            case 'float':
                $result = (float)$result;
                break;
            case 'binary':
                $result = (binary)$result;
                break;
            default:
                $result = $result;
                break;
        }
        return $result;
    }

    /**
     * 关闭模板
     */
    public function disableView()
    {
        Yaf_Dispatcher::getInstance()->autoRender(FALSE);
    }

    /**
     * 关闭Layout
     */
    public function disableLayout()
    {
        $isXmlHttpRequest = $this->getRequest()->isXmlHttpRequest();
        if ($isXmlHttpRequest == false) {
            $this->getView()->setLayout('');
        }
        //$this->getView()->setLayout('');
    }


    /**
     * 使用session
     * @param $namespace
     * @return Q_Core_SessionNamespace
     */
    public function _sessionNamespace($namespace)
    {
        $this->sessionStart();
        if (empty($this->_sessionNamespace[$namespace])) {
            $this->_sessionNamespace[$namespace] = new Q_Core_SessionNamespace ($namespace);
        }
        return $this->_sessionNamespace[$namespace];
    }

    /**
     * 需要验证请调用该函数
     * @param string $refer
     * @return int
     */
    public function _auth($refer = 'auto')
    {
         $this->sessionStart();
         $this->pid = isset($_SESSION['sid']) ? $_SESSION['sid'] : 0;
         if (($this->pid) < 1) {
             $referUrl = $refer == 'auto' ? $_SERVER['REQUEST_URI'] : $refer;
             $domain = Q_APPLICATION_ENV == 'release' ? 'http://portal.admin.hunchelaila.com' : 'http://admin.hunchelaila.com';
             $redirectUrl = $domain.'/Login/index?refer=' . rawurlencode($referUrl);
             header('Location: ' . $redirectUrl);
             exit;
         }
         return $this->pid;
    }
    
    /**
     * 需要验证请调用该函数 header()后增加exit
     * @param string $refer
     * @return int
     */
    public function _authorize($refer = 'auto')
    {
         $this->sessionStart();
         $session = QINAuth_Factory::profile('mini_web');
         if (($this->pid = $session->getSession()) < 1) {
             $referUrl = $refer == 'auto' ? $_SERVER['REQUEST_URI'] : $refer;
             $redirectUrl = '/signin.html?refer=' . rawurlencode($referUrl);
             header('Location: ' . $redirectUrl);
             exit;
         }
         return $this->pid;
    }

    /**
     * 获取token_session_key
     * @return mixed
     */
    public function _sessionToken()
    {
//         $this->sessionStart();
//         $session = QINAuth_Factory::profile('mini_web');
//         return $session->getSession('token_session_key');
    }

    /**
     * 获取用户ID判断是否登录
     * @return int
     */
    public function _getpid()
    {
         $this->sessionStart();
         $this->pid = isset($_SESSION['sid']) ? $_SESSION['sid'] : $this->_auth();
         return $this->pid;
    }

    /**
     * 跳转地址
     * @param string $refer
     * @return string
     */
    public function gotoUrl($refer = '')
    {
        $Uri = '';
        if ($refer == '') {
            $Uri = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        }
        $referer = empty($_SERVER['HTTP_REFERER']) ? '' : $_SERVER['HTTP_REFERER'];
        if ($Uri == $referer) {
            $gotoUrl = '/';
        } else {
            $gotoUrl = !empty($refer) ? rawurldecode($refer) : '/';
        }
        return $gotoUrl;
    }

}