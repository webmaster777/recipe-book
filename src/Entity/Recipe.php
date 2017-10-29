<?php

namespace Mkroese\RecipeBook\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Recipe
 * @package Mkroese\RecipeBook\Entity
 *
 * @Entity
 * @ORM\Entity(repositoryClass="\Mkroese\RecipeBook\Entity\Repository\RecipeRepository")
 * @Table(name="recipe")
 *
 */
class Recipe {
  /**
   * @var int
   * @Id
   * @Column(type="integer")
   * @GeneratedValue
   */
  protected $id;

  /**
   * @var string
   * @Column(type="string")
   */
  public $title;

  public function getId() {
    return $this->id;
  }
}
