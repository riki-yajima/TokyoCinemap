<?php 
  session_start();

  function h($str) {
    return htmlspecialchars($str,ENT_QUOTES,"UTF-8");
  } 

  // 入力画面からのアクセスでなければ、戻す
  if (!isset($_SESSION['log_in'])) {
    header('Location: ./signup.php');
    exit();
  }else {
    $_POST = $_SESSION['log_in'];
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['log_in'] = $_POST;
    header('Location: ./login.php');
    exit();
  }

  unset($_SESSION['log_in']);
   
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

    <form class="login_1" action="signup_complete.php" method="POST">
      <dl>
        <dt><label for="email">メールアドレス</label></dt>
        <dd><?php echo h($_POST['email']);?></dd>
        <dt><label for="password">パスワード</label></dt>
        <dd><?php echo h($_POST['password']);?></dd>
        <dt><label for="name">ユーザネーム</label></dt>
        <dd><?php echo h($_POST['user_name']);?></dd>
        <p style="font-style: italic;font-size: smaller;">上記の内容で、登録が完了しました！<br>マイページからいつでも変更できます。</p>
        <button><a href="login.php">ログインページへ</a></button>
      </dl> 
    </form>

    <x-sign>
      Coming soon
    </x-sign>

  </section>

  <?php include('../parts/footer.php');?>
</body>
</html>