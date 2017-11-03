<?php

namespace Mkroese\RecipeBook\Test;

use DI\Container;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Helper\HelperSet;

class CheckContainerTest extends TestCase
{
  /**
   * @var Container
   */
  protected $container;

  public function setUp() {
    $this->container = require __DIR__.'/../index.php';
  }

  public function testContainer()
  {
    $this->assertInstanceOf(Container::class, $this->container,
      "container is not a php-di container");

    $title = $this->container->get('application.title');

    $this->assertNotEmpty($title, "application.title is empty");


    // assert we are able to get the doctrine helperset (for the doctrine cli)
    $helperset = $this->container->get('doctrine.orm.helperset');

    $this->assertInstanceOf(HelperSet::class, $helperset,
      'doctrine.orm.helperset is not a valid HelperSet');
  }
}
