<?php

namespace Mkroese\RecipeBook\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Recipe
 * @package Mkroese\RecipeBook\Entity
 *
 * @ORM\Entity(repositoryClass="\Mkroese\RecipeBook\Entity\Repository\RecipeRepository")
 * @ORM\Table(name="recipe")
 *
 */
class Recipe {
  /**
   * @var int
   *
   * @ORM\Id()
   * @ORM\Column(type="bigint")
   * @ORM\GeneratedValue()
   */
  protected $id;

  /**
   * @var string
   * @ORM\Column(type="string")
   */
  public $title;

  /**
   * @var CookingStep[]
   *
   * @ORM\OneToMany(targetEntity="CookingStep", mappedBy="CookingStep")
   */
  public $cookingSteps;

  public function getId() {
    return $this->id;
  }
}
