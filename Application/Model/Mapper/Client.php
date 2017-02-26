<?php

namespace Application\Model\Mapper;

use Fixeads\Orm\Mapper;

class Client extends Mapper
{
    protected $table = 'clients';
    protected $primaryKey = 'id';
    protected $adapter = null;
}
