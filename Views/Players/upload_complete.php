<?php 
  session_start();

  function h($str) {
    return htmlspecialchars($str,ENT_QUOTES,"UTF-8");
  } 

  // 入力画面からのアクセスでなければ、戻す
  if (!isset($_SESSION['up_load'])) {
    header('Location: ./upload.php');
    exit();
  }else {
    $_POST = $_SESSION['up_load'];
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['up_load'] = $_POST;
    header('Location: ./manage.php');
    exit();
  }

  unset($_SESSION['up_load']);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" type="text/css" href="/css/style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="/js/index.js"></script>
  <title>映画の新規登録完了ページ</title>
</head>
<body>
  <div id="header_1">
  <?php include('../parts/header.php');?>
  </div>
  
  <section id="profile_edit">

    <div class="main_area">
      <form method="POST" action="">
      <dl>
      <dt><h1>映画の登録が完了しました！</h1><dt>
      <dt><a href="movie_list.php">映画一覧ページへ</a></dt>
    </dl>
      </form>
    </div>
  
  </section>
  
  <?php include('../parts/footer.php');?>

</body>
</html>