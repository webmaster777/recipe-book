<?php

// main entry point of the application

$container = require_once __DIR__ . '/../index.php';

$app = $container->get('application');

printf('This is "%s" version %s', $app->getName() ,$app->getFullVersion());

echo PHP_EOL;
