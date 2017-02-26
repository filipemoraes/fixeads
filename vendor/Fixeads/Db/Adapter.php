<?php

namespace Fixeads\Db;

use Fixeads\Db\Adapter\DbInterface;

class Adapter
{
    private $config = null;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function factory()
    {
        $db = $this->config['db'];

        $class = __NAMESPACE__ . '\Adapter\DbAdapter' . $db;

        return new $class($this->config);
    }
}
