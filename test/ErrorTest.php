<?php

namespace Mkroese\RecipeBook\Test;

use DI\Container;
use Interop\Container\ContainerInterface;
use PHPUnit\Framework\TestCase;
use Slim\App;
use Slim\Http\Environment;
use Slim\Http\Request;

class ErrorTest extends TestCase
{
  /**
   * @var Container
   */
  protected $container;

  public function setUp() {
    $this->container = require __DIR__.'/../index.php';
  }

  public function test404() {

    // create mock request
    $env = Environment::mock([
      'REQUEST_METHOD' => 'GET',
      'REQUEST_URI'    => '/non-existent-url/really',
    ]);
    $request = Request::createFromEnvironment($env);

    $this->container->set('request',$request);
    $app = $this->container->get(App::class);
    $response = $app->run(true);

    $this->assertEquals(404, $response->getStatusCode());
  }
}
