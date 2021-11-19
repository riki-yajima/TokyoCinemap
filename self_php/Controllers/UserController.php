<?php
require_once(ROOT_PATH .'/Models/User.php');


class UserController {
  private $User;

  public function __construct() {
    $this->request['get'] = $_GET;
    $this->request['post'] = $_POST;

    $this->User = new User();
  }

  public function log_in(){
    $result = $this->User->LogIn($this->request['post']);
    return $result;
  }
  
  public function sign_up(){
    $result = $this->User->SignUp($this->request['post']);
    return $result;
  }
  
  public function show() {
    if(empty($this->request['get']['id'])) {
      echo '指定のパラメーターが不正です。このページを表示できません。';
      exit;
    }
    
    $users = $this->User->findById($this->request['get']['id']);
    
    $row = [
      'users' => $users
    ];
    return $row;
  }

  public function update() {
    if (empty($this->request['get']['id'])) {
      echo '指定のパラメータが不正です。このページを表示できません。';
      exit();
    }
    $this->User->UpdateAccount($this->request['post']);
  }

  public function delete() {
    if (empty($this->request['get']['id'])) {
      echo '指定のパラメータが不正です。このページを表示できません。';
      exit();
    }
    $this->User->deleteById($this->request['get']['id']);
  }

}