<?php

// main entry point of the application

/** @var \DI\Container $container */
$container = require_once __DIR__ . '/../index.php';

$app = $container->get(\Slim\App::class);

$app->run();
