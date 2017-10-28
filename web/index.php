<?php

// main entry point of the application

require_once __DIR__ . '/../vendor/autoload.php';

echo "hello recipe-book (autoload ='" .  __DIR__ . '/../vendor/autoload.php' . "')<br />" . PHP_EOL;

$app = new \Mkroese\RecipeBook\Application();

printf('This is "%s" version %s', $app->getName() ,$app->getFullVersion());

echo PHP_EOL;
