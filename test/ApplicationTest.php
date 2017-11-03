<?php

namespace Mkroese\RecipeBook\Test;

use DI\Container;
use Mkroese\RecipeBook\Application;
use PHPUnit\Framework\TestCase;

class ApplicationTest extends TestCase
{
  /**
   * @var Container
   */
  protected $container;

  /**
   * @var Application
   */
  protected $application;

  public function setUp() {
    $this->container = require __DIR__.'/../index.php';
    /** @var Application $application */
    $this->application = $this->container->get('application');
  }

  /**
   * @expectedException \InvalidArgumentException
   */
  public function testInvalidVersionPart() {
    /** @var Application $application */
    $this->application->getVersionPart('not-a-valid-version-part');
  }

  public function versionPartsProvider()
  {
    return [
      ["major"],
      ["minor"],
      ["patch"],
      ["prerelease"],
      ["build"]
    ];
  }

  /**
   * @param $part
   *
   * @dataProvider versionPartsProvider
   */
  public function testVersionPart($part) {
    $this->application->getVersionPart($part);
    $this->addToAssertionCount(1);
  }

  public function testDefaultConstructor()
  {
    $application = new Application();

    $this->assertInstanceOf(Application::class, $application);
  }

  public function testConstructorWithVersion()
  {
    $version = "aversionstring";
    $application = new Application("My Application",$version);

    $this->assertInstanceOf(Application::class, $application);

    $this->assertEquals($version,$application->getFullVersion());

  }
}
