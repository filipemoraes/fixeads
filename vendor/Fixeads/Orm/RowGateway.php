<?php

namespace Fixeads\Orm;

class RowGateway
{
    protected $adapter = null;
    protected $element = null;
    protected $mapper = null;

    public function __construct($element, $adapter, $mapper)
    {
        $this->adapter = $adapter;
        $this->element = $element;
        $this->mapper = $mapper;
    }

    public function __get($attribute)
    {
        return $this->element[$attribute];
    }

    public function __set($attribute, $value)
    {
        $this->element[$attribute] = $value;
    }
}
