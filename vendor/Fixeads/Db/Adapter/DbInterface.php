<?php

namespace Fixeads\Db\Adapter;

interface DbInterface
{
    public function __construct(array $config);
    public function select($table, $cols = '*', $where = null);
    public function insert($table, array $fields);
    public function getFields($table);
}
