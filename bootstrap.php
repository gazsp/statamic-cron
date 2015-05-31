#! /usr/bin/env php
<?php

$_SERVER['SERVER_NAME'] = 'cli';
$_SERVER['SERVER_PORT'] = 0;
$_SERVER['REQUEST_URI'] = '';
$_SERVER['REMOTE_ADDR'] = '127.0.0.1';
$_SERVER['HTTP_HOST'] = 'localhost';
$_SERVER['REQUEST_METHOD'] = 'GET';

define('STATAMIC_VERSION', false);
define("STATAMIC_START", microtime(true));
define("BASE_PATH", 'public');
define("APP_PATH", "public/_app");

date_default_timezone_set('UTC');

require_once APP_PATH . '/vendor/Slim/Slim.php';
require_once APP_PATH . '/vendor/SplClassLoader.php';

\Slim\Slim::registerAutoloader();

$packages = array(
  'Buzz',
  'Carbon',
  'emberlabs',
  'Intervention',
  'Michelf',
  'Netcarver',
  'Stampie',
  'Symfony',
  'Whoops',
  'Zeuxisoo',
  'erusev',
  'Propel'
);

foreach ($packages as $package) {
    $loader = new SplClassLoader($package, APP_PATH . '/vendor/');
    $loader->register();
}

require_once APP_PATH . '/vendor/Spyc/Spyc.php';
require_once APP_PATH . '/vendor/Lex/Parser.php';
require_once APP_PATH . '/core/exceptions.php';
require_once APP_PATH . '/core/functions.php';

// register the Statamic autoloader
spl_autoload_register("autoload_statamic");

$app = require_once BASE_PATH . '/_app/start.php';

if($argc == 2) {
    require_once "commands/{$argv[1]}.php";
}
else {
    echo "Usage: bootstrap.php <scriptname>\n";
}
