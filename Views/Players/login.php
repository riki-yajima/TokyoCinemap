<?php
  require_once(ROOT_PATH.'Controllers/UserController.php');

  //エスケープ処理
  function h($str) {
    return htmlspecialchars($str,ENT_QUOTES,"UTF-8");
  }

  session_start();

  if(!empty($_POST) && empty($_SESSION['log_in'])){

    //POSTのValidate

    if(empty($_POST['user_name'])){
      $err['user_name'] = 'ユーザーネームは必須項目です。';
    }

    if(empty($_POST['email'])){
      $err['email'] = 'メールアドレスは必須項目です。';
    }

    if (!preg_match('/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/iD', $_POST['email'])) {
      $err['email'] = 'メールアドレスを正しく入力してください。';
    }

    if (empty($_POST['password'])) {
      $err['password'] = 'パスワードは必須項目です。';
    }

    if (mb_strlen($_POST['password']) < 8) {
      $err['password'] = 'パスワードは8文字以上です。';
    }

  if(empty($err)){
      $user = new UserController();
      $err['log_in'] = $user->log_in();
      $_SESSION['log_in'] = $_POST;
    }
  }elseif(!empty($_SESSION['log_in'])){
    header('location: ./login_complete.php');
  }
  
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" type="text/css" href="/css/style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="/js/index.js"></script>
  <title>ログインページ</title>
</head>
<body>

  <div id="header_1">
  <?php include('../parts/login_header.php');?>
  </div>
 
  <section id="login_1">

    <h1>ログインページ</h1>

    <form class="login_1" action="login.php" method="POST">
      <dl>
      <dt><label for="name">ユーザネーム</label>
        <p class="err_message"><?php if(isset($err['user_name'])){echo $err['user_name'];} ?></p>
        </dt>
        <dd><input type="text" name="user_name" id="user_name" value="<?php echo isset($_POST['user_name']) ? h($_POST['user_name']) : ''; ?>"></dd>
        <dt><label for="email">メールアドレス</label>
        <p class="err_message"><?php if(isset($err['email'])){ echo $err['email']; } ?></p>
        </dt>
        <dd><input type="email" name="email" id="email" placeholder="sample@sample.com" value="<?php echo isset($_POST['email']) ? h($_POST['email']) : ''; ?>"></dd>
        <dt><label for="password">パスワード</label>
        <p class="err_message"><?php if(isset($err['password'])){ echo $err['password']; } ?></p>
        </dt>
        <dd><input type="password" name="password" id="password" value=""<?php echo isset($_POST['password']) ? h($_POST['password']) : ''; ?>"></dd>
        <button type="submit">ログイン</button>
        <a href="signup.php">新規会員登録はこちら</a>
        <p class="err_message" style="font-size: 1.0em;">
          <?php
            if(isset($err['log_in'])){
              echo $err['log_in'];
            }
            ?>
        </p>
      </dl> 
      <input type="hidden" name="id" value = "37" checked>
      <input type="hidden" name="role" value = "1" checked>
    </form>
    <x-sign>
      Coming soon
    </x-sign>

  </section>


  <?php include('../parts/footer.php');?>
</body>
</html>