<?php

namespace Controller;

class LoginController extends \Configs\Controller
{
  public function index($request, $response, $args) {
    $message = $request->getQueryParam('message');
    $message_color = '';
    if($message != ''){
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

  public function sign_in($request, $response, $args) {
    $this->load_helper('cipher');
    $user = \Model::factory('\Models\User', 'app')
      ->where('user', $request->getParam('user'))
      ->where('pass', encrypt(
          $this->constants['key'],
          $request->getParam('password')
        )
      )
      ->find_one();
    if($user != false){
      // set SESSION
      $_SESSION['lang'] = 'sp';
      $_SESSION['user_id'] = $user->id;
      $_SESSION['email'] = $user->email;
      $_SESSION['picture'] = $user->picture;
      $_SESSION['profile'] = 'teacher';
      $_SESSION['state'] = 'active';
      $_SESSION['time'] = date('Y-m-d H:i:s');
      return $response = $response->withRedirect(
        $this->constants['base_url']
      );
    }else{
      $status = 500;
      $this->load_helper('login');
      $locals = [
        'constants' => $this->constants,
        'title' => 'Login',
        'csss' => $this->load_css(index_css($this->constants)),
        'jss'=> $this->load_js(index_js($this->constants)),
        'message_color' => 'text-danger',
        'message' => 'Usuario y/o contraenia no coinciden',
      ];
      $view = $this->container->view;
      return $view($response, 'blank', 'login/index.phtml', $locals);
    }
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
