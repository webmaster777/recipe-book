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
   * @param bool $deletedRecipe
   * @return string
   */
  public function getHome(InvokerInterface $container, bool $deletedRecipe = false)
  {
    $recipes = $container->call([Recipe::class,"getRecipeList"]);

    if($deletedRecipe)
      $this->addAlert("Recipe was deleted succesfully");

    return $this->render("index.html.twig",[
      "recipes" => $recipes
    ]);
  }
}
