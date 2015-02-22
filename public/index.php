<?php

use Phalcon\Mvc\Micro;

error_reporting(E_ALL);

define('APP_PATH', realpath('..'));

$debug = new \Phalcon\Debug();
$debug->listen();

/**
 * Read the configuration
 */
$config = new \Phalcon\Config\Adapter\Ini(__DIR__ . "/../config/config.ini");

/**
 * Include Services
 */
include APP_PATH . '/config/services.php';

/**
 * Include Autoloader
 */
include APP_PATH . '/config/loader.php';

/**
 * Starting the application
 * Assign service locator to the application
 */
$app = new Micro($di);

/**
 * Include Application
 */
include APP_PATH . '/app.php';

/**
 * Handle the request
 */
$app->handle();