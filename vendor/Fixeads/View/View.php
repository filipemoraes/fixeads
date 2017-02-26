<?php

namespace Fixeads\View;

class View
{
    protected $path = null;
    protected $controller = null;
    protected $element = array();

    private $blocks = [];
    private $currentBlock;

    public function __construct($controller)
    {
        $this->controller = $controller;
    }

    public function setPath($path)
    {
        $this->path = $path;
    }

    public function render($action)
    {
        $action = str_replace('Action','', $action);
        require $this->path . DIRECTORY_SEPARATOR . $this->controller->getName() .
            DIRECTORY_SEPARATOR . $action . '.php';
    }

    public function extend($view)
    {
        require $this->path . DIRECTORY_SEPARATOR . $view . '.php';
    }

    function block($block) {
        $this->currentBlock = $block;

        ob_start();
    }

    function endBlock() {
        $this->blocks[$this->currentBlock] = ob_get_clean();
    }

    public function getBlock($block)
    {
        return isset($this->blocks[$block])
            ? $this->blocks[$block]
            : ''
        ;
    }

    public function __get($name)
    {
        return $this->element[$name];
    }

    public function __set($name, $value)
    {
        $this->element[$name] = $value;
    }
}
