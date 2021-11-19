<?php
session_start();

if(empty($_SESSION['log_in'])){
  header('location: ./login.php');
}else {
  isset($_SESSION['log_in']);
}

$id = $_SESSION['id'];

require_once(ROOT_PATH .'Controllers/PlayerController.php');
$bookmark = new PlayerController();
$bookmark->delete();
header("Location: ./bookmarklist.php?id=$id");
exit();
?>