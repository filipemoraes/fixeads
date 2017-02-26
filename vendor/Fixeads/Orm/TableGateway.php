<?php

namespace Fixeads\Orm;

use Fixeads\Util\Iterator\Collection;
use Fixeads\Db\Adapter\DbInterface;

class TableGateway extends Collection
{
    protected $table = null;
    protected $adapter = null;
    protected $rowClass = '\\Fixeads\\Orm\\RowGateway';

    public function __construct($table, DbInterface $adapter)
    {
        $this->table = $table;
        $this->adapter = $adapter;
    }

    public function select($cols = '*',$where = [])
    {
        $rowClass = $this->rowClass;
        $collection = $this->adapter->select($this->table, $cols, $where);
        foreach($collection->getElements() as $element)
            $this->elements[] = new $rowClass($element, $this->adapter, $this);

        return $this;
    }

    public function getAdapter()
    {
        return $this->adapter;
    }
}
