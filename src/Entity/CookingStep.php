<?php

namespace Mkroese\RecipeBook\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class CookingStep
 * @package Mkroese\RecipeBook\Entity
 *
 * @ORM\Entity()
 * @ORM\Table(name="cookingstep")
 */
class CookingStep
{
  /**
   * @var int
   *
   * @ORM\Column(type="integer")
   * @ORM\Id()
   * @ORM\GeneratedValue()
   */
  protected $id;

  /**
   * @var Recipe
   *
   * @ORM\ManyToOne(targetEntity="Recipe", inversedBy="cookingSteps")
   */
  protected $recipe;

  /**
   * @var string
   * @ORM\Column(type="text")
   */
  protected $instructions;

  /**
   * @return int
   */
  public function getId(): int
  {
    return $this->id;
  }

  /**
   * @param string $instructions
   * @return CookingStep
   */
  public function setInstructions(string $instructions): CookingStep
  {
    $this->instructions = $instructions;
    return $this;
  }

  /**
   * @return string
   */
  public function getInstructions(): string
  {
    return $this->instructions;
  }

  /**
   * @param Recipe $recipe
   * @return CookingStep
   */
  public function setRecipe(Recipe $recipe): CookingStep
  {
    $this->recipe = $recipe;
    return $this;
  }

  /**
   * @return Recipe
   */
  public function getRecipe(): Recipe
  {
    return $this->recipe;
  }
}
