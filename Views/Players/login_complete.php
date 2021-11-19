<?php 

  session_start();

  require_once(ROOT_PATH.'Controllers/UserController.php');
  
  function h($str) {
    return htmlspecialchars($str,ENT_QUOTES,"UTF-8");
  } 

  // 入力画面からのアクセスでなければ、戻す
  if (!isset($_SESSION['log_in'])) {
    header('Location: ./login.php');
    exit();
  }else {
    $_POST = $_SESSION['log_in'];
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['log_in'] = $_POST;
    header('Location: ./mypage.php');
    exit();
  }

  $user_id = $_SESSION['log_in']['id'];
  var_dump($user_id);

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" type="text/css" href="/css/style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="/js/index.js"></script>
  <title>サインアップ完了ページ</title>
</head>
<body>

  <div id="header_1">
  <?php include('../parts/login_header.php');?>
  </div>

  <section id="login_1">

    <form class="login_1" action="login_complete.php" method="POST">
      <dl>
        <input type="hidden" name="id" value="<?= h($user_id); ?>">
        <p style="font-style: italic;font-size: smaller;">ログインが完了しました！</p>
        <button><a href="mypage.php?id=<?= h($user_id); ?>">マイページへ</a></button>
      </dl> 
    </form>

    <x-sign>
      Coming soon
    </x-sign>

  </section>

  <?php include('../parts/footer.php');?>
</body>
</html>