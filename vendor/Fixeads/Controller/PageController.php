<?php

namespace Fixeads\Controller;

use Fixeads\View\View;

abstract class PageController
{
    protected $view = null;
    protected $action = null;

    public function __construct()
    {
        $this->view = new View($this);
    }

    public function getView()
    {
        return $this->view;
    }

    public function preDispatch(){}

    public function dispatch($action, $args)
    {
        $this->action = $action;
        $this->preDispatch();
        $this->$action($args);
        $this->postDispatch();
    }

    public function postDispatch(){
        $this->view->render($this->action);
    }

    public function getName()
    {
        $class = str_replace('Application\Controller\\', '', get_class($this));
        return str_replace('Controller', '',$class);
    }

    protected function redirect($action)
    {
        $this->action = $action;
        $action .= 'Action';
        $this->$action();
    }

    protected static function POST($index)
    {
        return isset($_POST[$index]) ? $_POST[$index] : null;
    }

    protected static function GET($index)
    {
        return isset($_GET[$index]) ? $_GET[$index] : null;
    }
}
