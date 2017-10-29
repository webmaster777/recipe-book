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
   * @ORM\Column(type="bigint")
   * @ORM\Id()
   * @ORM\GeneratedValue()
   */
  protected $id;

  /**
   * @var Recipe
   *
   * @ORM\ManyToOne(targetEntity="Recipe")
   */
  protected $recipe;
}
