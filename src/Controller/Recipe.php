<?php
/**
 * Created by PhpStorm.
 * User: meindertjan
 * Date: 28/10/2017
 * Time: 19:56
 */

namespace Mkroese\RecipeBook\Controller;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityNotFoundException;
use Mkroese\RecipeBook\Application;
use Mkroese\RecipeBook\Entity\CookingStep;
use \Mkroese\RecipeBook\Entity\Recipe as RecipeEntity;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\Request;

class Recipe extends Base
{
  protected $repository, $enitityManager;

  public function __construct(Application $application, \Twig_Environment $twig, EntityManager $entityManager)
  {
    parent::__construct($application, $twig);

    $this->enitityManager = $entityManager;
    $this->repository = $entityManager->getRepository(RecipeEntity::class);
  }

  public function editRecipe(Request $request, ResponseInterface $response, $id = null)
  {
    if($id === null) {
      $entity = new RecipeEntity();
    }
    else {
      $entity = $this->repository->find($id);
    }

    if(!$entity)
      throw new EntityNotFoundException('Recipe not found!');

    // technical form info
    $form = [
      "method" => "post",
    ];

    if($request->getMethod() === "POST") {
      $entity->title = $request->getParam("title");

      $steps =  $request->getParam("cooking-steps");

      $steps = array_map('trim',preg_split('/\R{2}/',$steps));

      foreach ($entity->cookingSteps as $cookingStep) {
        $this->enitityManager->remove($cookingStep);
      }
      $entity->cookingSteps->clear();

      foreach ($steps as $step) {
        if(!$step) {
          continue;
        }

        $cookingStep = new CookingStep();
        $this->enitityManager->persist($cookingStep);
        $entity->cookingSteps->add($cookingStep
          ->setInstructions($step)
          ->setRecipe($entity));
      }

      // Save recipe to the database.
      $this->enitityManager->persist($entity);
      $this->enitityManager->flush($entity);

      $this->addAlert(<<<MSG
Recipe saved! You can continue to edit this or <a class="alert-link" href="/">return to the list</a>.
MSG
      , "success");

      // note the fallthrough, we show the (updated) form again.
      $form["action"] = "/recipe/" . $entity->getId() . "/edit";
    }


    // create rendering context
    $context = [
      "form" => $form,
      "recipe" => $entity
    ];

    $content =  $this->render("recipe/edit.html.twig", $context);

    $response->getBody()->write($content);
    return $response;
  }

  public function deleteRecipe($id, ResponseInterface $response)
  {
    if($id)
      $entity = $this->repository->find($id);

    if (!$id || !$entity)
      throw new EntityNotFoundException("no or invalid id provided");

    $this->enitityManager->remove($entity);
    $this->enitityManager->flush($entity);

    return $response->withHeader('Location',
      sprintf('%s?deletedRecipe=true', $this->application->getBaseHref()));
  }

  public function getRecipeList($limit = null)
  {
    return $this->repository->findBy([],['id' => 'ASC'],$limit);
  }
}
