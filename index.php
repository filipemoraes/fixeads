<?php

error_reporting(0);
session_start();

use Fixeads\Util\Autoloader;
use Fixeads\Db\Adapter as DbAdapter;
use Fixeads\Orm\Mapper;
use Fixeads\Controller\FrontController;
use Fixeads\Handler\ErrorHandler;

set_include_path(__DIR__ . PATH_SEPARATOR . get_include_path());
set_include_path((realpath(__DIR__ . '/vendor' ). PATH_SEPARATOR . get_include_path()));

require 'Fixeads/Util/Autoloader.php';
$autoloader = Autoloader::getInstance();

$config = parse_ini_file(sprintf(__DIR__ . '%sconfig.ini', DIRECTORY_SEPARATOR));

$errorHandler = new ErrorHandler($config['debug']);

$dbAdapter = new DbAdapter($config);
Mapper::$defaultAdapter = $dbAdapter->factory();

$frontController = FrontController::getInstance();
$frontController->setPath(sprintf(__DIR__ . '%sApplication%1$sView', DIRECTORY_SEPARATOR));
$frontController->dispatch();
