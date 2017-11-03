<?php

namespace Mkroese\RecipeBook\Test;

use DI\Container;
use PHPUnit\Framework\TestCase;

class CheckContainerTest extends TestCase
{
  public function testContainer()
  {
    /** @var Container $container */
    $container = include __DIR__ . '/../index.php';

    $this->assertInstanceOf(Container::class, $container,"container is not a php-di container");

    $title = $container->get('application.title');

    $this->assertNotEmpty($title, "application.title is empty");

    return $container;
  }
}
