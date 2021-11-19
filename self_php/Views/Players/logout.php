<?php
session_start();
$_SESSION['log_in'] = null;
session_destroy();
header('location: ./login.php');
?>