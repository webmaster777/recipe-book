<?php

namespace Mkroese\RecipeBook\Controller;

use Mkroese\RecipeBook\Application;

class Index
{
  protected $app;
  protected $twig;

  /**
   * Index constructor. (should be injected)
   *
   * @param Application $app
   * @param \Twig_Environment $twig
   */
  public function __construct(Application $app, \Twig_Environment $twig)
  {
    $this->app = $app;
    $this->twig = $twig;
  }

  /**
   * renders the index.html template
   *
   * @return string
   */
  public function getHome()
  {
    return $this->twig->render("index.html",[
      "application" => [
        "title"=>$this->app->getName(),
        "version" => $this->app->getFullVersion(),
      ]
    ]);
  }
}
