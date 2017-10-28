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

  // application instance
  'application' => object(\Mkroese\RecipeBook\Application::class)
    ->constructor(get('application.title'), get('application.version')),
  \Mkroese\RecipeBook\Application::class => get('application'),

  // doctrine orm settings
  'doctrine.orm.connection' => [
    'driver' => 'pdo_sqlite',
    'path'   => __DIR__ . '/exampledb.db',
  ],
  'doctrine.orm.config' => function() {
    return \Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration(array(__DIR__."/src"), true);
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

];
