<?php

namespace Mkroese\RecipeBook\Controller;

use DI\InvokerInterface;
use Mkroese\RecipeBook\Application;

class Index extends Base
{
  protected $app;

  /**
   * renders the index.html.twig template
   *
   * @param InvokerInterface $container
   * @return string
   */
  public function getHome(InvokerInterface $container)
  {
    $recipes = $container->call([Recipe::class,"getRecipeList"]);

    return $this->render("index.html.twig",[
      "recipes" => $recipes
    ]);
  }
}
