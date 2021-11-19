<?php
session_start();

require_once(ROOT_PATH .'Controllers/UserController.php');
$user = new UserController();
$user->delete();
$_SESSION['log_in'] = null;
session_destroy();
header("Location: ./login.php");
exit();
?>