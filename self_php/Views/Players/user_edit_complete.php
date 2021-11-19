<?php
session_start();

//エスケープ処理
function h($str) {
  return htmlspecialchars($str,ENT_QUOTES,"UTF-8");
}

if(empty($_SESSION['log_in'])){
  header('location: ./login.php');
}else {
  $_POST = $_SESSION['log_in'];
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" type="text/css" href="/css/style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="/js/index.js"></script>
  <title>アカウント編集完了ページ</title>
</head>
<body>

  <div id="header_1">
  <?php include('../parts/header.php');?>
  </div>

  <section id="login_1">

  <form class="login_1">
      <h1>アカウントの編集が完了しました！</h1>
      <a href="mypage.php?id=<?= h($_SESSION['log_in']['id']); ?>">マイページへ</a>
  </form>

  </section>

  <?php include('../parts/footer.php');?>
</body>
</html>