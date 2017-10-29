<?php

namespace Mkroese\RecipeBook\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
   * @ORM\Column(type="integer")
   * @ORM\GeneratedValue()
   */
  protected $id;

  /**
   * @var string
   * @ORM\Column(type="string")
   */
  public $title;

  /**
   * @var Collection|CookingStep[]
   *
   * @ORM\OneToMany(targetEntity="CookingStep", mappedBy="recipe", cascade={"all"})
   */
  public $cookingSteps;

  public function __construct()
  {
    $this->cookingSteps = new ArrayCollection();
  }

  public function getId() {
    return $this->id;
  }
}
