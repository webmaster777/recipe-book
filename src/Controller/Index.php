<?php

namespace Mkroese\RecipeBook\Controller;

use DI\InvokerInterface;
use Mkroese\RecipeBook\Application;

class Index
{
  protected $app;

  /**
   * Index constructor. (should be injected)
   *
   * @param Application $app
   */
  public function __construct(Application $app)
  {
    $this->app = $app;
  }

  /**
   * renders the index.html.twig template
   *
   * @param InvokerInterface $container
   * @param \Twig_Environment $twig
   * @return string
   */
  public function getHome(InvokerInterface $container, \Twig_Environment $twig)
  {
    $recipes = $container->call([Recipe::class,"getRecipeList"]);

    return $twig->render("index.html.twig",[
      "application" => $this->app,
      "recipes" => $recipes
    ]);
  }
}
