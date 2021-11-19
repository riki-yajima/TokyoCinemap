<?php

require_once(ROOT_PATH.'Controllers/PlayerController.php');

//エスケープ処理
function h($str) {
  return htmlspecialchars($str,ENT_QUOTES,"UTF-8");
}

session_start();

if(!empty($_POST) && empty($_SESSION['up_load'])){
  
  //POSTのValidate。

  if(empty($_POST['title'])){
    $err['title'] = 'タイトルは必須項目です。';
  }

  if (empty($_POST['coming'])) {
    $err['coming'] = '公開日は必須項目です。';
  }

  if(empty($_POST['country'])){
    $err['country'] = '制作国は必須項目です。';
  }

  if(empty($_POST['genre'])){
    $err['genre'] = 'ジャンルは必須項目です。';
  }

  if(empty($_POST['story'])){
    $err['story'] = 'あらすじは必須項目です。';
  }

  if(empty($_FILES['image']['name'])){
    $err['image'] = '画像は必須項目です。';
  }

  if(empty($err)) {
    $_SESSION['up_load'] = $_POST;
    $movie = new PlayerController();
    $result = $movie->upload();
    header('Location: ./upload_complete.php');
    exit();
  }
  
}elseif(!empty($_SESSION['up_load'])){
  header('Location: ./upload_complete.php');
}


?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" type="text/css" href="/css/style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="/js/index.js"></script>
  <title>映画の新規登録ページ</title>
</head>
<body>
  <div id="header_1">
  <?php include('../parts/header.php');?>
  </div>
  
  <section id="profile_edit">

    <h1>映画の新規登録</h1>

    <div class="main_area">


      <form class="login_1" style="padding-top: 30px;" action="" method="POST" enctype="multipart/form-data">
        <dl>
          <dt><label for="title">タイトル</label>
          <p class="err_message red"><?php if(isset($err['title'])){ echo $err['title']; } ?></p>
          </dt>
          <dd><input type="text" name="title" id="title" value="<?php echo isset($_POST['title']) ? h($_POST['title']) : ''; ?>"></dd>
          <dt><label for="coming">公開日</label>
          <p class="err_message red"><?php if(isset($err['coming'])){ echo $err['coming']; } ?></p>
          </dt>
          <dd><input type="date" name="coming" id="coming" value="<?php echo isset($_POST['coming']) ? h($_POST['coming']) : ''; ?>"></dd>
          <dt><label for="country">制作国</label>
          <p class="err_message red"><?php if(isset($err['country'])){ echo $err['country']; } ?></p>
          </dt>
          <dd><input type="text" name="country" id="country" value="<?php echo isset($_POST['country']) ? h($_POST['country']) : ''; ?>"></dd>
          <dt><label for="genre">ジャンル</label>
          <p class="err_message red"><?php if(isset($err['genre'])){ echo $err['genre']; } ?></p></dt>
          <dd><input type="text" name="genre" id="genre" value="<?php echo isset($_POST['genre']) ? h($_POST['genre']) : ''; ?>"></dd>
          <dt><label for="story">あらすじ(700文字以内)</label>
          <p class="err_message red"><?php if(isset($err['story'])){ echo $err['story']; } ?></p>
          </dt>
          <dd><textarea type="text" name="story" id="story" placeholder=""><?php echo isset($_POST['story']) ? h($_POST['story']) : ''; ?></textarea></dd>
          <dt><label for="image">イメージ画像(png/jpg)</label>
          <p class="err_message red"><?php if(isset($err['image'])){ echo $err['image']; } ?></p>
          </dt>
          <dd><input type="file" name="image" id="image" accept="image/*"/ value="<?php echo isset($_FILES['image']['name']) ? h($_FILES['image']['name']) : ''; ?>"></dd>
          <p>入力内容に間違いありませんか？</p>

          <dt><button type="submit">登録</button></dt>
        </dl> 
      </form>
    </div>
  
  </section>
  
  <?php include('../parts/footer.php');?>

</body>
</html>