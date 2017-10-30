<?php

namespace Mkroese\RecipeBook\Controller;

use DI\InvokerInterface;
use Doctrine\ORM\EntityManager;
use Mkroese\RecipeBook\Entity\Repository\RecipeRepository;

class Index extends Base
{
  protected $app;

  /**
   * renders the index.html.twig template
   *
   * @param InvokerInterface $invoker
   * @param EntityManager $entityManager
   * @param bool $deletedRecipe
   * @param string|null $q
   * @return string
   */
  public function getHome(InvokerInterface $invoker, EntityManager $entityManager,
                          bool $deletedRecipe = false, string $q = null)
  {
    if(!$q) {
      $recipes = $invoker->call([Recipe::class,"getRecipeList"], ["limit" => 10]);
    }
    else
    {
      /** @var RecipeRepository $repo */
      $repo = $entityManager->getRepository(\Mkroese\RecipeBook\Entity\Recipe::class);
      $recipes = $repo->findWithTitleLike($q);

      if(!$recipes || !count($recipes))
      {
        $this->addAlert("No recipes matched your query", "warning");
      }
    }

    if($deletedRecipe)
      $this->addAlert("Recipe was deleted succesfully");

    $context = [
      "recipes" => $recipes,
      "q" => $q
    ];


    return $this->render("index.html.twig", $context);
  }
}
