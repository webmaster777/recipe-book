<?php
/**
 * Created by PhpStorm.
 * User: meindertjan
 * Date: 29/10/2017
 * Time: 14:48
 */

namespace Mkroese\RecipeBook\Controller;


use Mkroese\RecipeBook\Application;

abstract class Base
{
  protected $application, $twig;

  /**
   * Base constructor.
   * @param Application $application
   * @param \Twig_Environment $twig
   */
  public function __construct(Application $application, \Twig_Environment $twig)
  {
    $this->application = $application;
    $this->twig = $twig;
  }

  /**
   * @param string $template
   * @param array $additionalContext
   * @return string
   */
  protected function render(string $template, array $additionalContext)
  {
    return $this->twig->render($template, array_merge($this->getRenderContext(),$additionalContext));
  }

  /**
   * @return array
   */
  protected function getRenderContext()
  {
    return [
      "application" => $this->application,
      "alerts" => $this->alerts,
    ];
  }

  protected $alerts = [];

  /**
   * @param string $message
   * @param string $type one of <code>['danger','info','success','warning']</code>
   */
  protected function addAlert(string $message, $type = "info")
  {
    $this->alerts[] = ["message" => $message,"type" => $type];
  }
}
