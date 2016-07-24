<?php

/**
 * Created by PhpStorm.
 * User: zhanglirong
 * Date: 16-1-12
 * Time: 10:26
 */




class QLib_Layout implements Yaf_View_Interface
{
    public $breadcrumb = array();

    public $engine;

    protected $options = array();

    protected $layout_path;

    protected $layout;

    protected $content;

    protected $tpl_vars = array();

    protected $tpl_dir;

    public function __construct($path, $options = array())
    {
        $this->layout_path = $path;
        $this->options = $options;
    }

    protected function engine()
    {
        $this->engine = $this->engine ? : new Yaf_View_Simple(
            $this->tpl_dir,
            $this->options
        );
        return $this->engine;
    }

    public function setScriptPath($path)
    {
        if (is_readable($path)) {
            $this->tpl_dir = $path;
            $this->engine()->setScriptPath($path);
            $this->layout_path = $path . "/../layouts";
            return true;
        }
        throw new Exception("Invalid path: {$path}");
    }

    public function getScriptPath()
    {
        return $this->engine()->getScriptPath();
    }

    public function setLayout($name)
    {
        $this->layout = $name;
    }

    public function getLayout()
    {
        return $this->layout;
    }

    public function setLayoutPath($path)
    {
        $this->layout_path = $path;
        return $this;
    }

    public function getLayoutPath()
    {
        $config = Yaf_Application::app()->getConfig()->get('application');
        return $this->layout_path . "/" . $this->layout . ".{$config->view->ext}";
    }

    public function __set($name, $value)
    {
        $this->assign($name, $value);
    }

    public function __isset($name)
    {
        return (null !== $this->engine()->$name);
    }

    public function __unset($name)
    {
        $this->engine()->clear($name);
    }

    public function assign($name, $value = null)
    {
        $this->tpl_vars[$name] = $value;
        $this->engine()->assign($name, $value);
    }

    public function assignRef($name, &$value)
    {
        $this->tpl_vars[$name] = $value;
        $this->engine()->assignRef($name, $value);
    }

    public function clearVars()
    {
        $this->tpl_vars = array();
        $this->engine()->clear();
    }

    public function render($tpl, $tpl_vars = array())
    {
        $tpl_vars = array_merge($this->tpl_vars, $tpl_vars);
        $this->content = $this->engine()->render($tpl, $tpl_vars);
        if (null == $this->layout) {
            return $this->content;
        }
        $ref = new ReflectionClass($this->engine());
        $prop = $ref->getProperty('_tpl_vars');
        $prop->setAccessible(true);
        $view_vars = $prop->getValue($this->engine());
        $tpl_vars = array_merge($tpl_vars, $view_vars);
        $tpl_vars['content'] = $this->content;
        $this->engine()->assign('breadcrumb', $this->breadcrumb);
        return $this->engine()->render(
            $this->getLayoutPath(),
            $tpl_vars
        );
    }

    public function display($tpl, $tpl_vars = array())
    {
        echo $this->render($tpl, $tpl_vars);
    }
}
