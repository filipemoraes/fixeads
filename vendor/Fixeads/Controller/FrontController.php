<?php

namespace Fixeads\Controller;

class FrontController
{
    private static $instance = null;
    private $path = null;

    private function __construct(){}

    public function setPath($path)
    {
        $this->path = $path;
    }

    public function getPath()
    {
        return $this->path;
    }

    public static function getInstance()
    {
        if (self::$instance == null)
            self::$instance = new FrontController();

        return self::$instance;
    }

    public function dispatch($_controller = '', $_action = '', $args = [])
    {
        $controller = isset($_GET['controller']) ? $_GET['controller'] : 'index';
        if(!empty($_controller))
            $controller = $_controller;

        $action = isset($_GET['action']) ? $_GET['action'] : 'index';
        if(!empty($_action))
            $action = $_action;

        $file = __DIR__ . '/../../../Application/Controller/'. ucfirst($controller) . 'Controller.php';
        $controller = 'Application\\Controller\\'. ucfirst($controller) . 'Controller';
        $action .= 'Action';

        if(!file_exists($file)) {
            $controller = 'Application\\Controller\\ErrorController';
            $action = 'indexAction';
            $args = ['code' => 404];
        }

        $controller = new $controller();
        $controller->getView()->setPath($this->path);
        $controller->dispatch($action, $args);
    }
}
