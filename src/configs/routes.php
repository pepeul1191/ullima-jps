<?php

use Slim\Http\Request;
use Slim\Http\Response;
// controllers
use Controller\ErrorController;
use Controller\LoginController;
use Controller\OAuthController;
use Controller\HomeController;
use Controller\StudentController;
use Controller\SectionController;

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
$app->get('/login/change_password', LoginController::class . ':change_password');
$app->post('/login/change', LoginController::class . ':change');
$app->post('/login/reset', LoginController::class . ':reset');
$app->get('/login/sign_out', LoginController::class . ':sign_out');
// home
$app->get('/', HomeController::class . ':index');
// student
$app->post('/student/update_teamviewer', StudentController::class . ':update_teamviewer');
// section
$app->get('/section/get_students', SectionController::class . ':get_students');
