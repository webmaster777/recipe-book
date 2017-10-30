<?php

// main entry point of the application

/** @var \DI\Container $container */
$container = require_once __DIR__ . '/../index.php';

$app = new \Slim\App($container);

// home
$app->get('/',
  [\Mkroese\RecipeBook\Controller\Index::class,'getHome']);

// edit/add a recipe
$app->map(['get','post'],'/recipe/{id}/edit',
  [\Mkroese\RecipeBook\Controller\Recipe::class,'editRecipe']);
$app->map(['get','post'],'/recipe/add',
  [\Mkroese\RecipeBook\Controller\Recipe::class,'editRecipe']);

// delete routes
$app->delete('/recipe/{id}',[
  \Mkroese\RecipeBook\Controller\Recipe::class,'deleteRecipe']);
$app->get('/recipe/{id}/delete',
  [\Mkroese\RecipeBook\Controller\Recipe::class,'deleteRecipe']);


$app->run();
