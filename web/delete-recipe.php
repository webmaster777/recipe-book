<?php

// main entry point of the application

/** @var \DI\Container $container */
$container = require_once __DIR__ . '/../index.php';

echo $container->call([Mkroese\RecipeBook\Controller\Recipe::class, "deleteRecipe"],$_GET);
