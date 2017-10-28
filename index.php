<?php

// make sure we required the autoloader
require_once __DIR__ . '/vendor/autoload.php';

// read config into the container
$builder = new \DI\ContainerBuilder();
$builder->addDefinitions(require __DIR__ . '/config.php');

$additionalConfigPath = __DIR__.'/environment.config.php';
if(file_exists($additionalConfigPath))
  $builder->addDefinitions(require $additionalConfigPath);

$container = $builder->build();

// return the container (for includers)
return $container;
