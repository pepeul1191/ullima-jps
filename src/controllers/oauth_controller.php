<?php

namespace Controller;

class OAuthController extends \Configs\Controller
{
  private function google($request, $response, $constants) { 
    $code = $request->getParam('code');
    // get oauth google token
    $r_oauth = \Unirest\Request::post(
      'https://oauth2.googleapis.com/token', 
      array(), // headers 
      array(
        'client_id' => $constants['oauth']['google']['client_id'],
        'client_secret' => $constants['oauth']['google']['client_secret'],
        'code' => $code,
        'grant_type' => 'authorization_code',
        'redirect_uri' => $constants['base_url'] . 'oauth/callback?origin=google',
      ) // body
    );
    // get oauth google user
    $r_user = \Unirest\Request::get(
      'https://www.googleapis.com/oauth2/v1/userinfo',
      array(), // headers 
      array(
        'access_token' => $r_oauth->body->access_token,
      ) // body
    );
    // check if user is a student
    $student = \Model::factory('\Models\Student', 'app')
      ->where('email', $r_user->body->email)
      ->find_one();
    if($student != false){
      // insert data to students table if is first log
      if($student->name == ''){
        $code = explode('@',$r_user->body->email);
        $student->name = $r_user->body->name;
        $student->code = $code[0];
        $student->picture = $r_user->body->picture;
        $student->save();
      }
      // set SESSION
      $_SESSION['lang'] = $r_user->body->locale;
      $_SESSION['user_id'] = $r_user->body->id;
      $_SESSION['email'] = $r_user->body->email;
      $_SESSION['name'] = $r_user->body->name;
      $_SESSION['picture'] = $r_user->body->picture;
      $_SESSION['profile'] = 'student';
      $_SESSION['state'] = 'active';
      $_SESSION['time'] = date('Y-m-d H:i:s');
      $response = $response->withRedirect(
        $this->constants['base_url']
      );
    }else{
      $response = $response->withRedirect(
        'https://accounts.google.com/Logout?continue=https://appengine.google.com/_ah/logout?continue=' . 
        $this->constants['base_url'] . 'login?message=student-not-exist'
      );
    }
    return $response;
  }

  public function callback($request, $response, $args) {
    $origin = $request->getParam('origin');
    if($origin == 'google'){
      $response = $this->google($request, $response, $this->constants);
    }
    return $response;
  }
}
