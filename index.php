<?php
if (PHP_SAPI == 'cli-server') {
  // To help the built-in PHP dev server, check if the request was actually for
  // something which should probably be served as a static file
  $url  = parse_url($_SERVER['REQUEST_URI']);
  $file = __DIR__ . $url['path'];
  if (is_file($file)) {
    return false;
  }
}

require __DIR__ . '/vendor/autoload.php';

session_start();

// Instantiate the app
$settings = require __DIR__ . '/src/configs/settings.php';
$app = new \Slim\App($settings);

// Register database
require __DIR__ . '/src/configs/database.php';
// Set up dependencies
require __DIR__ . '/src/configs/dependencies.php';
// Register middleware
require __DIR__ . '/src/configs/middleware.php';
// Register routes
require __DIR__ . '/src/configs/routes.php';

/*CORS*/
$app->options('/api/{routes:.+}', function ($request, $response, $args) {
  return $response;
});
$app->add(function ($req, $res, $next) {
  $response = $next($req, $res);
  return $response
    ->withHeader('Access-Control-Allow-Origin', '*')
    ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization, csrf_val')
    ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH');
});
// Run app
$app->run();
