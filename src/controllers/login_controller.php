<?php

namespace Controller;

class LoginController extends \Configs\Controller
{
  public function index($request, $response, $args) {
    $message = $request->getQueryParam('message');
    $message_color = '';
    if($message == ''){
      $message = 'El usuario ingresado no corresponde a un alumno registrado, <b>no se olvide de cerrar su sesión con Google antes de volver a intentar ingresar nuevamente</b>';
      $message_color = 'text-danger';
    }
    $this->load_helper('login');
    $rpta = '';
    $status = 200;
    $locals = [
      'constants' => $this->constants,
      'title' => 'Login',
      'csss' => $this->load_css(index_css($this->constants)),
      'jss'=> $this->load_js(index_js($this->constants)),
      'message_color' => $message_color,
      'message' => $message,
    ];
    $view = $this->container->view;
    return $view($response, 'blank', 'login/index.phtml', $locals);
  }

  public function sign_up($request, $response, $args) {
    $this->load_helper('login');
    $rpta = '';
    $status = 200;
    $locals = [
      'constants' => $this->constants,
      'title' => 'Registrarse',
      'csss' => $this->load_css(index_css($this->constants)),
      'jss'=> $this->load_js(index_js($this->constants)),
      'message' => '',
    ];
    $view = $this->container->view;
    return $view($response, 'blank', 'login/signup.phtml', $locals);
  }

  public function password($request, $response, $args) {
    $this->load_helper('login');
    $rpta = '';
    $status = 200;
    $locals = [
      'constants' => $this->constants,
      'title' => 'Registrarse',
      'csss' => $this->load_css(index_css($this->constants)),
      'jss'=> $this->load_js(index_js($this->constants)),
      'message' => '',
    ];
    $view = $this->container->view;
    return $view($response, 'blank', 'login/password.phtml', $locals);
  }

  public function sign_out($request, $response, $args) {
    // build logout url
    $logout_url = $this->constants['base_url'];
    if($_SESSION['profile'] == 'student'){
      // url for student
      
      $logout_url = 
        'https://accounts.google.com/Logout?continue=https://appengine.google.com/_ah/logout?continue=' . 
        $this->constants['base_url'] . 'login';
    }else{
      // url for teacher
      $logout_url = $this->constants['base_url'] . 'login';
    }
    // destroy session
    session_destroy();
    return $response->withRedirect($logout_url);
  }
}
