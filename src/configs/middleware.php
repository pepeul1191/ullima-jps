<?php
// Application middleware

// e.g: $app->add(new \Slim\Csrf\Guard);
$mw_ambiente_csrf = function ($request, $response, $next) {
  $settings = require 'settings.php';
  $continuar = true;
  if($settings['settings']['constants']['ambiente_csrf'] == 'active'){
    if($request->getHeader($settings['settings']['constants']['csrf']['key'])[0] != 
        $settings['settings']['constants']['csrf']['secret']){
      $continuar = false;
    }
  }
  if($continuar == true){
    $response = $next($request, $response);
    return $response;
  }else{
    $status = 500;
    $rpta = json_encode(
      [
        'No se puede acceder al recurso',
        'CSRF Token key error',
      ]
    );
    return $response->withStatus($status)->write($rpta);
  }
};

$mw_session_true = function ($request, $response, $next) {
  $settings = require 'settings.php';
  $continuar = true;
  if($settings['settings']['constants']['ambiente_session'] == 'active'){
    if (array_key_exists('state', $_SESSION)) {
      if($_SESSION['state'] != 'active'){
        $continuar = false;
      }
    }else{
      $continuar = false;
    }
  }
  if($continuar == true){
    $response = $next($request, $response);
    return $response;
  }else{
    $status = 500;
    $response = $response->withRedirect($this->constants['base_url'] . 'error/access/505');
    return $response;
  }
};

$mw_session_false = function ($request, $response, $next) {
  $settings = require 'settings.php';
  $error = true;
  if($settings['settings']['constants']['ambiente_session'] == 'active'){
    if (array_key_exists('state', $_SESSION)) {
      if($_SESSION['state'] == 'active'){
        $error = false;
      }
    }else{
      $error = true;
    }
  }
  if($error == true){
    $response = $next($request, $response);
    return $response;
  }else{
    $status = 500;
    $response = $response->withRedirect($this->constants['base_url']);
    return $response;
  }
};
