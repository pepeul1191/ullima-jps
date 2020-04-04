<?php

use Slim\Http\Request;
use Slim\Http\Response;
// controllers
use Controller\ErrorController;

// Routes
$app->get('/demo/[{name}]', function (Request $request, Response $response, array $args) {
  // Sample log message
  $this->logger->info("Slim-Skeleton '/' route");
  // Render index view
  return $this->renderer->render($response, 'index.phtml', $args);
});

//error
$app->get('/error/access/{numero}', ErrorController::class . ':access');