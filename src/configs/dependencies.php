<?php
// DIC configuration
$container = $app->getContainer();
// view renderer
$container['renderer'] = function ($c) {
  $settings = $c->get('settings')['renderer'];
  return new Slim\Views\PhpRenderer($settings['template_path']);
};
// monolog
$container['logger'] = function ($c) {
  $settings = $c->get('settings')['logger'];
  $logger = new Monolog\Logger($settings['name']);
  $logger->pushProcessor(new Monolog\Processor\UidProcessor());
  $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
  return $logger;
};

$container['constants'] = function ($c) {
  return $c->get('settings')['constants'];
};

$container['view'] = function ($c) {
  return function($response, $partial, $template, $locals) {
    $view = new Slim\Views\PhpRenderer(__DIR__ . '/../templates/');
    $view->render($response, 'partials/' . $partial . '_header.phtml', $locals);
    $view->render($response, $template, $locals);
    $view->render($response, 'partials/' . $partial . '_footer.phtml', $locals);
  };
};

$container['notFoundHandler'] = function ($c) {
  return function ($request, $response) use ($c) {
    $method = $request->getMethod();
    if($method == 'GET'){
      return $response->withRedirect($c->get('settings')['constants']['base_url'] . 'error/access/404');
    }else{
      $rpta = json_encode(
        [
          'tipo_mensaje' => 'error',
          'mensaje' => [
            'Recurso no disponible',
            'Error 404'
          ]
        ]
      );
      return $c['response']
        ->withStatus(404)
        ->withHeader('Allow', $method)
        ->withHeader('Content-type', 'text/html')
        ->write($rpta);
    }
  };
};

$container['notAllowedHandler'] = function ($c) {
  return function ($request, $response, $methods) use ($c) {
    $rpta = json_encode(
      [
        'tipo_mensaje' => 'error',
        'mensaje' => [
          'Error,no se puede acceder al recurso',
          'Operación HTTP no es la adecuada'
        ]
      ]
    );
    return $c['response']
      ->withStatus(405)
      ->withHeader('Allow', implode(', ', $methods))
      ->withHeader('Content-type', 'text/html')
      ->write($rpta);
  };
};
