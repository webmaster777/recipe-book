<?php

// make sure we required the autoloader
require_once __DIR__ . '/vendor/autoload.php';

// read config into the container
$builder = new \DI\ContainerBuilder();

// Add slim config
$builder->addDefinitions(require  __DIR__. '/vendor/php-di/slim-bridge/src/config.php');

// Add standard config
$builder->addDefinitions(require __DIR__ . '/config.php');

// Add additional config (use this to disable debug modes etc)
$additionalConfigPath = __DIR__.'/environment.config.php';
if(file_exists($additionalConfigPath))
  $builder->addDefinitions(require $additionalConfigPath);

// This file should contain a closure that accepts the builder as argument
$cacheConfigurator = __DIR__.'/cache.config.php';
if(file_exists($cacheConfigurator)){
  $closure = require $cacheConfigurator;
  $closure($builder);
}

$container = $builder->build();

// return the container (for includers)
return $container;
