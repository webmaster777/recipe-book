<?php

// main entry point of the application

/** @var \DI\Container $container */
$container = require_once __DIR__ . '/../index.php';

$route = @$_SERVER['PATH_INFO']; // ignore not defined notice.
$pieces = array_filter(explode('/',$route));


// 404 function
$error404 = function () use (&$container) {
  header('HTTP/1.1 404 Not Fond of looking',true,404);

  $context = ["error" =>
    ["code"=>404, "shortMessage" => "Not Found", "longMessage"=> <<<MSG
Uh oh, looks like we couldn't find what you were looking for. You should ask Bono, though.
MSG
    ],
    "application" => $container->get(\Mkroese\RecipeBook\Application::class),
  ];

  $twig = $container->get(\Twig_Environment::class);
  echo $twig->render('error.html.twig',$context);
};

if(!count($pieces)) {
  $first = null;
}
else {
  $first = array_shift($pieces);
}

switch ($first) {
  case 'recipe':
    if(count($pieces)) {
      $second = array_shift($pieces);
    }
    else {
      $second = null;
    }

    if(!$second)
    {
      echo $container->call([Mkroese\RecipeBook\Controller\Index::class, "getHome"], $_GET);
      return;
    }
    if($second == "add") {
      // new recipe
      echo $container->call([Mkroese\RecipeBook\Controller\Recipe::class, "editRecipe"],$_GET);
      return;
    }

    $second = intval($second);
    $_GET["id"] = $second;

    if(count($pieces)) {
      $third = array_shift($pieces);
    }
    else {
      $third = null;
    }

    switch ($third) {
      case null:
      case 'view':
      case 'edit':
        echo $container->call([Mkroese\RecipeBook\Controller\Recipe::class, "editRecipe"],$_GET);
        return;
      case 'delete':
        echo $container->call([Mkroese\RecipeBook\Controller\Recipe::class, "deleteRecipe"],$_GET);
        return;
      default:
        $error404();
        return;
    }
  case null:
    echo $container->call([Mkroese\RecipeBook\Controller\Index::class, "getHome"], $_GET);
    return;
  default:
    // generate 404
    $error404();

    return;
}
