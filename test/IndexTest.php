<?php

namespace Mkroese\RecipeBook\Test;

use DI\Container;
use Doctrine\ORM\EntityManager;
use Mkroese\RecipeBook\Entity\CookingStep;
use Mkroese\RecipeBook\Entity\Recipe;
use PHPUnit\Framework\TestCase;
use Slim\App;
use Slim\Http\Environment;
use Slim\Http\Request;

class IndexTest extends TestCase
{
  /**
   * @var Container
   */
  protected $container;

  public function setUp() {
    $this->container = require __DIR__.'/../index.php';
  }

  public function testHomepage() {
    // create mock request
    $env = Environment::mock([
      'REQUEST_METHOD' => 'GET',
      'REQUEST_URI'    => '/',
    ]);
    $request = Request::createFromEnvironment($env);

    $this->container->set('request',$request);
    $app = $this->container->get(App::class);
    $response = $app->run(true);

    $this->assertEquals(200, $response->getStatusCode());

    $body = strval($response->getBody());


    $this->assertRegExp("/because all good things should be done well./", $body);
    $this->assertRegExp("/feel free to add a recipe./", $body);
  }

  public function testSearchNoResults() {
    // create mock request
    $env = Environment::mock([
      'REQUEST_METHOD' => 'GET',
      'REQUEST_URI'    => '/?q=no+recipes+should+be+found+using+this+query',
    ]);
    $request = Request::createFromEnvironment($env);

    $this->container->set('request',$request);
    $app = $this->container->get(App::class);
    $response = $app->run(true);

    $this->assertEquals(200, $response->getStatusCode());

    $body = strval($response->getBody());

    $this->assertRegExp("/No recipes matched your query/", $body);
  }


  public function testSearch() {

    $title = "A test recipe";

    $em = $this->container->get(EntityManager::class);

    $recipe = new Recipe();
    $recipe->title = $title;

    $firstStep = new CookingStep();
    $firstStep->setInstructions("Step one");
    $firstStep->setRecipe($recipe);

    $recipe->cookingSteps->add($firstStep);

    $em->persist($recipe);
    $em->flush();

    // create mock request
    $env = Environment::mock([
      'REQUEST_METHOD' => 'GET',
      'REQUEST_URI'    => '/?q=reci',
    ]);
    $request = Request::createFromEnvironment($env);

    $this->container->set('request',$request);
    $app = $this->container->get(App::class);
    $response = $app->run(true);

    $this->assertEquals(200, $response->getStatusCode());

    $body = strval($response->getBody());

    $this->assertRegExp("/A test recipe/", $body);

    $em->remove($recipe);
    $em->flush();
  }

  public function testDeletedAlert() {
    // create mock request
    $env = Environment::mock([
      'REQUEST_METHOD' => 'GET',
      'REQUEST_URI'    => '/?deletedRecipe=true',
    ]);
    $request = Request::createFromEnvironment($env);

    $this->container->set('request',$request);
    $app = $this->container->get(App::class);
    $response = $app->run(true);

    $this->assertEquals(200, $response->getStatusCode());

    $body = strval($response->getBody());


    $this->assertRegExp("/Recipe was deleted successfully/", $body);
  }
}
