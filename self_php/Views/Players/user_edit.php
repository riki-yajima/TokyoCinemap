<?php
session_start();

require_once(ROOT_PATH.'Controllers/UserController.php');
$user = new UserController();
$row = $user->show();

//エスケープ処理
function h($str) {
  return htmlspecialchars($str,ENT_QUOTES,"UTF-8");
}

if (!isset($_SESSION['log_in'])) {
  header('Location: ./login.php');
  exit();
}else {
  $_POST = $_SESSION['log_in'];
}

$id = $row['users']['id'];
$user_name = $row['users']['user_name'];
$email = $row['users']['email'];
$password = $row['users']['password'];
$role = $row['users']['role'];


// エラー配列取得
$err = isset($_SESSION['error']) ? $_SESSION['error'] : NULL;
// エラー取得
$err_user_name = isset( $err['user_name'] ) ? $err['user_name'] : NULL;
$err_email = isset( $err['email'] ) ? $err['email'] : NULL;
// $err_password = isset( $err['password'] ) ? $err['password'] : NULL;


?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" type="text/css" href="/css/style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="/js/index.js"></script>
  <title>アカウント編集</title>
</head>

<body>
  <div id="header_1">
  <?php include('../parts/header.php');?>
  </div>
  
  <section id="profile_edit">

    <h1>アカウント編集</h1>

    <div class="main_area">


      <form class="login_1" action="user_update.php?id=<?= h($id); ?>" method="POST" style="padding-top: 30px;">
        <dl>         
          <input type="hidden" name="id" id="id" value="<?= h($id); ?>">
          <dt><label for="name">ユーザーネーム</label></dt><p class="err_message red"><?= h($err_user_name); ?></p>
          <dd><input type="text" name="user_name" id="user_name" value="<?= h($user_name); ?>"></dd>
          <dt><label for="email">メールアドレス</label></dt>
          <p class="err_message red"><?= h($err_email); ?></p>
          <dd><input type="text" name="email" id="email" value="<?= h($email); ?>"></dd>
          <!-- <dt><label for="password">パスワード</label>
          <p class="err_message"><?php if(isset($err['password'])){ echo $err['password']; } ?></p>
          </dt>
          <dd><input type="password" name="password" id="password" value="<?= h($password); ?>"></dd> -->
          <p>入力内容に間違いありませんか？</p>
          <dt><button type="submit">更新</button></dt>
          <a href="user_delete.php?id=<?= h($id); ?>" class="user_delete">アカウント削除</a>
        </dl> 
      </form>
    </div>
  
  </section>
  
  <?php include('../parts/footer.php');?>

</body>
</html>