<?php

namespace Fixeads\Orm;

class ActiveRecord extends RowGateway
{
    protected $state = 'decoupled';

    public function __construct($element, $adapter, $mapper, array $options = null)
    {
        parent::__construct($element, $adapter, $mapper);
        $this->state = isset($options['state']) ? $options['state'] : 'persistent';
    }

    public function insert()
    {
        return $this->adapter->insert($this->mapper->getTable(),
            $this->element
        );
    }

    public function save()
    {
        if ($this->state == 'new')
            return $this->insert();
    }
}
