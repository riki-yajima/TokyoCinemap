<?php
session_start();

if(!empty($_POST)){
  $id = $_POST['movie_id'];
  $user_id = $_POST['user_id'];
}

require_once(ROOT_PATH .'Controllers/PlayerController.php');
$bookmark = new PlayerController();
$bookmark->bookmark();
header("Location: ./movie.php?id=$id");
exit();

//エスケープ処理
function h($str) {
  return htmlspecialchars($str,ENT_QUOTES,"UTF-8");
}

?>