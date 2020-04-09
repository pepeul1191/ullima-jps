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
      return $view($response, 'app', 'home/' . $_SESSION['profile'] . '.phtml', $locals);
    }elseif($_SESSION['profile'] == 'teacher'){
      # TODO
      $locals['sections'] = \Model::factory('\Models\VWTeacherSection', 'app')
        ->where('teacher_id', $_SESSION['teacher_id'])
        ->find_array();
      return $view($response, 'app', 'home/' . $_SESSION['profile'] . '.phtml', $locals);
    }
  }
}
