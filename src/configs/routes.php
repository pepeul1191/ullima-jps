<?php

use Slim\Http\Request;
use Slim\Http\Response;
// controllers
use Controller\ErrorController;
use Controller\LoginController;
use Controller\OAuthController;
use Controller\HomeController;
use Controller\StudentController;

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
$app->post('/login/sign_in', LoginController::class . ':sign_in');
$app->get('/login/sign_up', LoginController::class . ':sign_up');
$app->post('/login/sign_up', LoginController::class . ':sign_up');
$app->get('/login/password', LoginController::class . ':password');
$app->post('/login/password', LoginController::class . ':password');
$app->get('/login/ver', LoginController::class . ':ver');
$app->get('/login/cerrar', LoginController::class . ':cerrar');
// home
$app->get('/', HomeController::class . ':index');
// student
$app->post('/student/update_teamviewer', StudentController::class . ':update_teamviewer');
