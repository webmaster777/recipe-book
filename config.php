<?php

use function \DI\get;
use function \DI\object;
use function \DI\decorate;
use function \DI\factory;

// this file returns php-di default config

return [
  // application settings
  'application.title' => "Meindert-Jan's Recipe Book",
  'application.version' => null, // let app automatically figure out
  'application.rootdir' => __DIR__,
  'application.baseHref' => '/', // overwrite this when deploying in a subfolder

  // application instance
  'application' => object(\Mkroese\RecipeBook\Application::class)
    ->constructor(get('application.title'), get('application.version'))
    ->constructorParameter('baseHref', get('application.baseHref')),
  \Mkroese\RecipeBook\Application::class => get('application'),

  // doctrine orm settings
  'doctrine.orm.connection' => [
    'driver' => 'pdo_sqlite',
    'path'   => __DIR__ . '/exampledb.db',
  ],
  'doctrine.orm.config' => function() {
    $config = \Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration(
      array(__DIR__."/src"), true, null, null, false);
    $config->setEntityNamespaces(['r'=>'\Mkroese\RecipeBook\Entity']);
    return $config;
  },
  \Doctrine\ORM\EntityManager::class => factory([\Doctrine\ORM\EntityManager::class, 'create'])
  ->parameter('conn', get('doctrine.orm.connection'))
  ->parameter('config',get('doctrine.orm.config')),
  'doctrine.orm.helperset' => function( Interop\Container\ContainerInterface $container ) {
    $entityManager = $container->get(\Doctrine\ORM\EntityManager::class);
    return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($entityManager);
  },

  // twig stuff
  'twig.paths' => [
    __DIR__.'/view',
  ],

  'twig.config' => [
    'debug' => true
  ],

  \Twig_LoaderInterface::class => object(\Twig_Loader_Filesystem::class)
    ->constructor(get('twig.paths')),
  \Twig_Environment::class => object()
    ->constructorParameter('options', get('twig.config')),

  // Slim settings
  'settings.displayErrorDetails' => true,
  'notFoundHandler' => get(Mkroese\RecipeBook\Controller\NotFound::class),


  // Slim application
  \Slim\App::class => function(\Interop\Container\ContainerInterface $container) {
    $app = new \Slim\App($container);

    // Add all routes

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

    return $app;
  }
];
