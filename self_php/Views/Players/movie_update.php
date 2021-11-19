<?php
session_start();

function h($str) {
  return htmlspecialchars($str,ENT_QUOTES,"UTF-8");
} 

if(empty($_SESSION['log_in'])){
  header('location: ./login.php');
}

$id = isset($_POST['id']) ? $_POST['id'] : NULL;
$title = isset($_POST['title']) ? $_POST['title'] : NULL;
$coming = isset($_POST['coming']) ? $_POST['coming'] : NULL;
$country = isset($_POST['country']) ? $_POST['country'] : NULL;
$genre = isset($_POST['genre']) ? $_POST['genre'] : NULL;
$story = isset($_POST['story']) ? $_POST['story'] : NULL;

// バリデーション
$err = [];

if(empty($title)){
  $err['title'] = 'タイトルは必須項目です。';
}

if (empty($coming)) {
  $err['coming'] = '公開日は必須項目です。';
}

if(empty($country)){
  $err['country'] = '制作国は必須項目です。';
}

if(empty($genre)){
  $err['genre'] = 'ジャンルは必須項目です。';
}

if(empty($story)){
  $err['story'] = 'あらすじは必須項目です。';
}

$_SESSION['error'] = $err;

if (count($err) > 0) {
  header("Location: ./movie_edit.php?id=$id");
  exit;
}

require_once(ROOT_PATH .'Controllers/PlayerController.php');
$movie = new PlayerController();
$movie->update();
header("Location: ./movie_edit_complete.php");
exit();

// セッションの破棄
$_SESSION = array();
session_destroy();

?>