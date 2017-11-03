<?php

namespace Mkroese\RecipeBook\Controller;

use DI\InvokerInterface;
use Doctrine\ORM\EntityManager;
use Mkroese\RecipeBook\Entity\Repository\RecipeRepository;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\Request;

class Index extends Base
{
  protected $app;

  /**
   * renders the index.html.twig template
   *
   * @param Request $request
   * @param ResponseInterface $response
   * @param InvokerInterface $invoker
   * @param EntityManager $entityManager
   * @return string
   */
  public function getHome(Request $request, ResponseInterface $response,
                          InvokerInterface $invoker, EntityManager $entityManager)
  {
    $deletedRecipe = $request->getParam('deletedRecipe', false);
    $q = $request->getParam('q', null);

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
      $this->addAlert("Recipe was deleted successfully");

    $context = [
      "recipes" => $recipes,
      "q" => $q
    ];


    $response->getBody()->write($this->render("index.html.twig", $context));
    return $response;
  }
}
