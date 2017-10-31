<?php

namespace Mkroese\RecipeBook\Controller;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class NotFound extends Base
{
  public function __invoke(RequestInterface $request, ResponseInterface $response) {
    $context = [
      "error" => [
        "code"=>404, "shortMessage" => "Not Found",
        "longMessage"=> <<<MSG
Uh oh, looks like we couldn't find what you were looking for. You should ask Bono, though.
MSG
      ],
    ];

    $response->getBody()
      ->write($this->render('error.html.twig',$context));

    return $response
      ->withStatus(404, 'Not Fond of looking');

  }
}
