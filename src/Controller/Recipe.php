<?php
/**
 * Created by PhpStorm.
 * User: meindertjan
 * Date: 28/10/2017
 * Time: 19:56
 */

namespace Mkroese\RecipeBook\Controller;


use Doctrine\ORM\EntityManager;
use \Mkroese\RecipeBook\Entity\Recipe as RecipeEntity;

class Recipe
{
  public function getRecipeList(EntityManager $em)
  {
    $repository = $em->getRepository(RecipeEntity::class);
    return $repository->findAll();
  }
}
