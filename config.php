<?php

use function \DI\get;
use function \DI\object;
use function \DI\decorate;

// this file returns php-di default config

return [
  'application.title' => "Meindert-Jan's Recipe Book",
  'application.version' => null, // let app automatically figure out
  'application.rootdir' => __DIR__,

  'application' => object(\Mkroese\RecipeBook\Application::class)
    ->constructor(get('application.title'), get('application.version')),
  
];
