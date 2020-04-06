<?php

namespace Controller;

class HomeController extends \Configs\Controller
{
  public function index($request, $response, $args) {
    $this->load_helper('home');
    $locals = [
      'constants' => $this->constants,
      'title' => 'Home',
      'csss' => $this->load_css(index_css($this->constants)),
      'jss'=> $this->load_js(index_js($this->constants)),
    ];
    $view = $this->container->view;
    if($_SESSION['profile'] == 'student'){
      $locals['student'] = \Model::factory('\Models\Student', 'app')
      ->where('email', $_SESSION['email'])
      ->find_one(); 
      $locals['logout_url'] = 'https://accounts.google.com/o/oauth2/v2/auth?response_type=code&client_id=' . $this->constants['oauth']['google']['client_id'] . '&redirect_uri=' . $this->constants['base_url'] . 'oauth/callback?origin=google&scope=profile email';
      return $view($response, 'app', 'home/' . $_SESSION['profile'] . '.phtml', $locals);
    }elseif($_SESSION['profile'] == 'teacher'){

    }
  }
}
