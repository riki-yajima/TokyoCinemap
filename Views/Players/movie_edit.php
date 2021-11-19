<?php
session_start();

require_once(ROOT_PATH .'Controllers/PlayerController.php');
$movie = new PlayerController();
$row = $movie->show();

//エスケープ処理
function h($str) {
  return htmlspecialchars($str,ENT_QUOTES,"UTF-8");
}

if(empty($_SESSION['log_in'])){
  header('location: ./login.php');
}

// データの代入
$id = $row['movie']['id'];
$title = $row['movie']['title'];
$coming = $row['movie']['coming'];
$country = $row['movie']['country'];
$genre = $row['movie']['genre'];
$story = $row['movie']['story'];
$file_name = $row['movie']['file_name'];

// エラー配列取得
$err = isset($_SESSION['error']) ? $_SESSION['error'] : NULL;
// エラー取得
$err_title = isset( $err['title'] ) ? $err['title'] : NULL;
$err_coming = isset( $err['coming'] ) ? $err['coming'] : NULL;
$err_country = isset( $err['country'] ) ? $err['country'] : NULL;
$err_genre = isset( $err['genre'] ) ? $err['genre'] : NULL;
$err_story = isset( $err['story'] ) ? $err['story'] : NULL;


?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" type="text/css" href="/css/style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="/js/index.js"></script>
  <title>映画の編集ページ</title>
</head>
<body>
  <div id="header_1">
  <?php include('../parts/header.php');?>
  </div>
  
  <section id="profile_edit">

    <h1>映画の編集</h1>

    <div class="main_area">

      <form class="login_1" style="padding-top: 30px;" action="movie_update.php?id=<?= h($id); ?>" method="POST">
        <dl>
          <dt><label for="title">タイトル</label>
          <p class="err_message red"><?= h($err_title); ?></p>
          </dt>
          <dd><input type="hidden" name="id" value="<?= h($id); ?>"</dd>
          <dd><input type="text" name="title" id="title" value="<?= h($title); ?>"></dd>
          <dt><label for="coming">公開日</label>
          <p class="err_message red"><?= h($err_coming); ?></p>
          </dt>
          <dd><input type="date" name="coming" id="coming" value="<?= h($coming); ?>"></dd>
          <dt><label for="country">制作国</label>
          <p class="err_message red"><?= h($err_country); ?></p>
          </dt>
          <dd><input type="text" name="country" id="country" value="<?= h($country); ?>"></dd>
          <dt><label for="genre">ジャンル</label>
          <p class="err_message red"><?= h($err_genre); ?></p>
          </dt>
          <dd><input type="text" name="genre" id="genre" value="<?= h($genre); ?>"></dd>
          <dt><label for="story">あらすじ</label>
          <p class="err_message red"><?= h($err_story); ?></p>
          </dt>
          <dd><textarea name="story" id="story" placeholder=""><?= h($story); ?></textarea></dd>
          <p>入力内容に間違いありませんか？</p>
          <dt><button type="submit">更新</button></dt>
        </dl> 
      </form>
    </div>
  
  </section>
  
  <?php include('../parts/footer.php');?>

</body>
</html>