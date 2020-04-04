<?php

use Slim\Http\Request;
use Slim\Http\Response;
// controllers
use Controller\ErrorController;
use Controller\LoginController;
use Controller\OAuthController;

// Routes
$app->get('/demo/[{name}]', function (Request $request, Response $response, array $args) {
  // Sample log message
  $this->logger->info("Slim-Skeleton '/' route");
  // Render index view
  return $this->renderer->render($response, 'index.phtml', $args);
});

// error
$app->get('/error/access/{numero}', ErrorController::class . ':access');
// oauth
$app->get('/oauth/callback', OAuthController::class . ':callback');
// login
$app->get('/login', LoginController::class . ':index')->add($mw_session_false);
$app->post('/login/acceder', LoginController::class . ':acceder');
$app->get('/login/ver', LoginController::class . ':ver');
$app->get('/login/cerrar', LoginController::class . ':cerrar');
