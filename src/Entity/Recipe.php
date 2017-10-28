<?php

namespace Mkroese\RecipeBook\Entity;

/**
 * Class Recipe
 * @package Mkroese\RecipeBook\Entity
 *
 * @Entity
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
