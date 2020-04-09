<?php

namespace Controller;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class LoginController extends \Configs\Controller
{
  public function index($request, $response, $args) {
    $message = $request->getQueryParam('message');
    $message_color = '';
    if($message != ''){
      $message = 'El usuario ingresado no corresponde a un alumno registrado';
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
      $_SESSION['teacher_id'] = $user->teacher_id;
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

  public function reset($request, $response, $args){
    $this->load_helper('login');
    // get user from password
    $user = \Model::factory('\Models\User', 'app')
      ->where('email', $request->getParam('email'))
      ->find_one();
    // if user not exist
    if($user == false){
      $locals = [
        'constants' => $this->constants,
        'title' => 'Login',
        'csss' => $this->load_css(index_css($this->constants)),
        'jss'=> $this->load_js(index_js($this->constants)),
        'message_color' => 'text-danger',
        'message' => 'Correo ingresado no se encuentra registrado',
      ];
      $view = $this->container->view;
      $response->withStatus(500);
      return $view($response, 'blank', 'login/password.phtml', $locals);
    }else{
      // change users's reset_key
      $this->load_helper('random');
      $reset_key = string_num(30);
      $user->reset_key = $reset_key;
      $user->save();
      // make link
      $url = 
        $this->constants['base_url'] . 
        'login/change_password?user_id=' . 
        $user->id . '&reset_key=' . $reset_key;
      // send email
      $layout = $this->get_mail_layout('reset_password');
      $base_url = $this->constants['base_url'];
      $favicon = $this->constants['static_url'] . 'favicon.ico';
      $data_layout = array(
        '%url' => $url, 
        '%base_url' => $base_url,
        '%favicon' => $favicon,
      );
      $message = str_replace(
        array_keys($data_layout), 
        array_values($data_layout), 
        $layout
      );
      $mail = new PHPMailer(true);
      try {
        // load .env
        $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '/../..');
        $dotenv->load();
        // server settings
        $mail->CharSet = 'UTF-8';
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Debugoutput = 'html';
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['GMAIL_USER'];
        $mail->Password = $_ENV['GMAIL_PASS'];
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
        // recipients
        $mail->setFrom(
          'support@softweb.pe', 
          'Soporte Software Web Perú'
        );
        $mail->addAddress(
          $request->getParam('email'), 
          ''
        );
        // content
        $mail->IsHTML(true);
        $mail->Subject = 'Solicitud de Cambio de Contraseña';
        $mail->Body = $message;
        // send
        $mail->send();
      } catch (Exception $e) {
        // echo 'Message could not be sent.';
        // echo 'Mailer Error: ' . $mail->ErrorInfo;
        $locals = [
          'constants' => $this->constants,
          'title' => 'Login',
          'csss' => $this->load_css(index_css($this->constants)),
          'jss'=> $this->load_js(index_js($this->constants)),
          'message_color' => 'text-danger',
          'message' => 'Ha ocurrido un error en enviar la solicitud de cambio a su correo.',
        ];
        $view = $this->container->view;
        $response->withStatus(500);
        return $view($response, 'blank', 'login/password.phtml', $locals);
      }
      // send message to view
      $locals = [
        'constants' => $this->constants,
        'title' => 'Login',
        'csss' => $this->load_css(index_css($this->constants)),
        'jss'=> $this->load_js(index_js($this->constants)),
        'message_color' => 'text-success',
        'message' => 'Se ha enviado la solicitud de cambio de contraseña a su correo.',
      ];
      $view = $this->container->view;
      $response->withStatus(200);
      return $view($response, 'blank', 'login/password.phtml', $locals);
    }
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

  public function change_password($request, $response, $args){
    $user = \Model::factory('\Models\User', 'app')
      ->where('id', $request->getQueryParam('user_id'))
      ->where('reset_key', $request->getQueryParam('reset_key'))
      ->find_one();
    if($user == false){
      $response->withStatus(404);
      $response = $response->withRedirect($this->constants['base_url'] . 'error/access/404');
      return $response;
    }else{
      $this->load_helper('login');
      $rpta = '';
      $status = 200;
      $locals = [
        'constants' => $this->constants,
        'title' => 'Login',
        'csss' => $this->load_css(index_css($this->constants)),
        'jss'=> $this->load_js(index_js($this->constants)),
        'message_color' => '',
        'message' => '',
        'user_id' => $request->getQueryParam('user_id'),
        'reset_key' => $request->getQueryParam('reset_key'),
      ];
      $view = $this->container->view;
      return $view($response, 'blank', 'login/reset.phtml', $locals);
    }
  }

  public function change($request, $response, $args){
    $user = \Model::factory('\Models\User', 'app')
      ->where('id', $request->getParam('user_id'))
      ->where('reset_key', $request->getParam('key'))
      ->find_one();
    if($user == false){
      $response->withStatus(404);
      $response = $response->withRedirect($this->constants['base_url'] . 'error/access/404');
      return $response;
    }else{
      // pass1 and pass2 must be the same
      if(
        $request->getParam('pass1') == $request->getParam('pass2')
      ){
        $this->load_helper('cipher');
        $this->load_helper('random');
        $this->load_helper('login');
        $user->pass = encrypt(
          $this->constants['key'],
          $request->getParam('pass1')
        );
        $user->reset_key = string_num(30);
        $user->save();
        $locals = [
          'constants' => $this->constants,
          'title' => 'Login',
          'csss' => $this->load_css(index_css($this->constants)),
          'jss'=> $this->load_js(index_js($this->constants)),
          'message_color' => 'text-success',
          'message' => 'Contraseña actualizada',
        ];
        $view = $this->container->view;
        return $view($response, 'blank', 'login/index.phtml', $locals);
      }else{
        $this->load_helper('login');
        $locals = [
          'constants' => $this->constants,
          'title' => 'Login',
          'csss' => $this->load_css(index_css($this->constants)),
          'jss'=> $this->load_js(index_js($this->constants)),
          'message_color' => 'text-danger',
          'message' => 'Contraseñas no coinciden.',
          'user_id' => $request->getParam('user_id'),
          'reset_key' => $request->getParam('key'),
        ];
        $view = $this->container->view;
        return $view($response, 'blank', 'login/reset.phtml', $locals);
      }
    }  
  }
}
