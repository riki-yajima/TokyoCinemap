<?php
session_start();

require_once(ROOT_PATH .'Controllers/PlayerController.php');
$movie = new PlayerController();
$movie->delete();
header("Location: ./movie_list.php?id=$id");
exit();
?>