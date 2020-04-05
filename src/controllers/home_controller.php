<?php

namespace Controller;

class HomeController extends \Configs\Controller
{
  public function index($request, $response, $args) {
    $locals = [
      'constants' => $this->constants,
      'title' => 'Home',
      'csss' => $this->load_css(array()),
      'jss'=> $this->load_js(array()),
    ];
    $view = $this->container->view;
    return $view($response, 'blank', 'home/index.phtml', $locals);
  }
}
