<?php

namespace Mkroese\RecipeBook\Test;

use DI\Container;
use Doctrine\ORM\EntityNotFoundException;
use Mkroese\RecipeBook\Controller\Recipe;
use PHPUnit\Framework\IncompleteTestError;
use PHPUnit\Framework\TestCase;
use Slim\App;
use Slim\Http\Environment;
use Slim\Http\Request;

class RecipeTest extends TestCase
{
  /**
   * @var Container
   */
  protected $container;

  public function setUp() {
    $this->container = require __DIR__.'/../index.php';
  }


  public function testAddRecipeForm() {
    // create mock request
    $env = Environment::mock([
      'REQUEST_METHOD' => 'GET',
      'REQUEST_URI'    => '/recipe/add',
    ]);
    $request = Request::createFromEnvironment($env);

    $this->container->set('request',$request);
    $app = $this->container->get(App::class);
    $response = $app->run(true);

    $this->assertEquals(200, $response->getStatusCode());

    $body = strval($response->getBody());


    $this->assertRegExp("/<form/",$body);
    $this->assertRegExp("#<label[^>]*>Title</label>#",$body);
  }


  public function testSaveNewRecipe() {
    $env = Environment::mock([
      'REQUEST_METHOD' => 'POST',
      'REQUEST_URI'    => '/recipe/add',
      'CONTENT_TYPE'   => 'application/x-www-form-urlencoded',
    ]);

    $request = Request::createFromEnvironment($env);
    $request = $request->withParsedBody([
      "title" => "a brand new recipe-title",
      "cooking-steps" => implode(PHP_EOL.PHP_EOL,["step one","step two"])
    ]);

    $this->container->set('request',$request);

    $app = $this->container->get(App::class);
    $response = $app->run(true);

    $this->assertEquals(200, $response->getStatusCode());

    $body = strval($response->getBody());

    $expected = "Recipe saved! You can continue to edit this";
    $this->assertRegExp("/$expected/",$body);

    $formactionregex = '%<form[^>]*action="/recipe/([^"]*)/edit"%';
    $this->assertRegExp($formactionregex,$body);
    if(preg_match($formactionregex,$body,$matches))
      return $matches[1];

    throw new IncompleteTestError();
  }

  /**
   * @param $id
   *
   * @depends testSaveNewRecipe
   */
  public function testEditRecipe($id) {
    $env = Environment::mock([
      'REQUEST_METHOD' => 'POST',
      'REQUEST_URI'    => "/recipe/$id/edit",
      'CONTENT_TYPE'   => 'application/x-www-form-urlencoded',
    ]);

    $request = Request::createFromEnvironment($env);
    $request = $request->withParsedBody([
      "title" => "a rebranded recipe-title",
      "cooking-steps" => implode(PHP_EOL.PHP_EOL,["stepper one",""])
    ]);

    $this->container->set('request',$request);

    $app = $this->container->get(App::class);
    $response = $app->run(true);

    $this->assertEquals(200, $response->getStatusCode());

    $body = strval($response->getBody());

    $expected = "Recipe saved! You can continue to edit this";
    $this->assertRegExp("/$expected/",$body);
  }

  public function testNotExistsEdit() {

    $env = Environment::mock([
      'REQUEST_METHOD' => 'GET',
      'REQUEST_URI'    => '/recipe/10022222222222230/edit',
    ]);

    $request = Request::createFromEnvironment($env);

    $this->container->set('request',$request);

    $app = $this->container->get(App::class);
    $response = $app->run(true);


    $this->assertEquals(500, $response->getStatusCode());

    $body = strval($response->getBody());

    $this->assertRegExp("#EntityNotFoundException#",$body);
  }

  /**
   * @param $id
   *
   * @depends testSaveNewRecipe
   */
  public function testDelete($id) {

    $env = Environment::mock([
      'REQUEST_METHOD' => 'DELETE',
      'REQUEST_URI'    => "/recipe/$id",
    ]);

    $request = Request::createFromEnvironment($env);

    $this->container->set('request',$request);

    $app = $this->container->get(App::class);
    $response = $app->run(true);


    $this->assertEquals(200, $response->getStatusCode());

  }
}
