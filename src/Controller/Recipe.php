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
use \Mkroese\RecipeBook\Entity\Recipe as RecipeEntity;

class Recipe
{
  protected $repository, $enitityManager, $application, $twig;

  public function __construct(Application $application, EntityManager $entityManager, \Twig_Environment $twig)
  {
    $this->enitityManager = $entityManager;
    $this->repository = $entityManager->getRepository(RecipeEntity::class);
    $this->application = $application;
    $this->twig = $twig;
  }

  public function editRecipe($id = null)
  {
    if($id === null) {
      $entity = new RecipeEntity();
    }
    else {
      $entity = $this->repository->find($id);
    }

    if(!$entity)
      throw new EntityNotFoundException('Recipe not found!');

    if($_SERVER["REQUEST_METHOD"] === "POST") {
      $entity->title = $_POST["title"];

      // Save recipe to the database.
      $this->enitityManager->persist($entity);
      $this->enitityManager->flush($entity);

      // note the fallthrough, we show the (updated) form again.
    }

    // technical form info
    $form = [
      "method" => "post",
    ];

    // create rencering context
    $context = [
      "application" => $this->application,
      "form" => $form,
      "recipe" => $entity
    ];

    return $this->twig->render("recipe/edit.html.twig", $context);
  }

  public function getRecipeList()
  {
    return $this->repository->findAll();
  }
}
