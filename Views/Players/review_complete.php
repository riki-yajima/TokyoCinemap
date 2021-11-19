<?php 
  session_start();

  function h($str) {
    return htmlspecialchars($str,ENT_QUOTES,"UTF-8");
  } 
  
  // 入力画面からのアクセスでなければ、戻す
  if (!isset($_SESSION['review'])) {
    header('Location: ./index.php');
    exit();
  }else {
    $_POST = $_SESSION['review'];
  }

  var_dump($_SESSION['review']);
  
  unset($_SESSION['review']);

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['log_in'] = $_POST;
    header('Location: ./mypage.php');
    exit();
  }

  // if(!isset($_SESSION['log_in'])) {
  //   isset($_SESSION['log_in']);
  // }else{
  // }
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" type="text/css" href="/css/style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="/js/index.js"></script>
  <title>レビュー完了ページ</title>
</head>
<body>

  <div id="header_1">
  <?php include('../parts/login_header.php');?>
  </div>

  <section id="login_1">

    <form class="login_1" action="review_complete.php" method="POST">
    <dl>
      <dt><h1>レビューが完了しました！</h1><dt>
      <dt><a href="mypage.php?id=<?= h($_SESSION['id']); ?>">マイページへ</a></dt>
    </dl>
    </form>

  </section>

  <?php include('../parts/footer.php');?>
</body>
</html>