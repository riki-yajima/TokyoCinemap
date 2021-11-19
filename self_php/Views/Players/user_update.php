<?php

session_start();

function h($str) {
  return htmlspecialchars($str,ENT_QUOTES,"UTF-8");
} 

$id = isset($_POST['id']) ? $_POST['id'] : NULL;
$user_name = isset($_POST['user_name']) ? $_POST['user_name'] : NULL;
$email = isset($_POST['email']) ? $_POST['email'] : NULL;

// バリデーション
$err = [];

if(empty($user_name)){
  $err['user_name'] = 'ユーザーネームは必須項目です。';
}

if(empty($_POST['email'])){
  $err['email'] = 'メールアドレスは必須項目です。';
}

if (!preg_match('/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/iD', $_POST['email'])) {
  $err['email'] = 'メールアドレス正しくを入力してください。';
}

// if (empty($_POST['password'])) {
//   $err['password'] = 'パスワードは必須項目です。';
// }

// if (mb_strlen($_POST['password']) < 8) {
//   $err['password'] = 'パスワードは8文字以上です。';
// }

$_SESSION['error'] = $err;

if (count($err) > 0) {
  header("Location: ./user_edit.php?id=$id");
  exit;
}


// アップデート処理
  require_once(ROOT_PATH .'Controllers/UserController.php');
  $user = new UserController();
  $user->update();
  header("Location: ./user_edit_complete.php");
  exit();

  // セッションの破棄
  $_SESSION = array();
  session_destroy();

?>