<?php
session_start();

//エスケープ処理
function h($str) {
  return htmlspecialchars($str,ENT_QUOTES,"UTF-8");
}

if(empty($_SESSION['log_in'])) {
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
  <title>管理者トップページ</title>
</head>
<body>

  <div id="header_1">
  <?php include('../parts/header.php');?>
  </div>
 
  <section id="manage">

  <h1>管理者トップページ</h1>

    <div class="manage_movie">
      <div class="upload">
        <a href="upload.php">①映画の新規登録</a>
      </div>
      <div class="movie_list">
        <a href="movie_list.php">②映画の編集・削除</a>
      </section>
      </div>
    </div>

  <?php include('../parts/footer.php');?>
</body>
</html>